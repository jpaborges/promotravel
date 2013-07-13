#-*-coding:utf-8-*-
import spynner
from datetime import timedelta, date,datetime
from BeautifulSoup import BeautifulSoup
from bd import BancoDados
import sys
import time
#TODO: Corrigir truncamento valores acima de 1000
class Voo:
	def __init__(self):
		self.bd = BancoDados()
		self.cod = 0 #No banco de dados os voos serao identificados por um cod para nao ter voos repitidos
		self.origem = "SSA"
		self.destino = "REC"
		self.dia = datetime(1,1,1)
		self.numErro = 0

		try:
			query = "SELECT Cod, Origem, Destino, Dia, NumErro from Voo where (pesquisando = 0 or (pesquisando = 1 and UltimaPesquisa < subtime(now(),'12:00'))) and UltimaPesquisa <  subtime(now(),'6:00') and Dia > adddate(now(),3) and Ocorrencia > 0 and NumErro < 5 order by prioridade desc limit 1;"#TODO: Ver o tempo exato ---A cada 6h,no maximo 5 erros
			voo = self.bd.executar(query)
			if (voo != None):
				for v in voo:
					self.cod = v[0]
					self.origem = v[1]
					self.destino = v[2]
					self.dia = v[3]
					self.numErro = v[4]
			
		except:
			print("Erro para ler os dados \n")

			raise
		finally:
			self.bd.desconectar() 

	
		
		'''Essa parte vai ser preenchida pelo crawler, por isso é private'''
		
		self.__preco = 0.01
		self.__cia = "Gol"
		self.__horaSaidaIda = "9:23"
		self.__horaChegadaIda = "10:10"
		self.__ultimaPesquisa = datetime(1,1,1)
		self.__status = 0 



	def __getUrl(self): 
		"""Retorna a url para fazer a pesquisa dessa passagem"""

		retorno = "http://www.decolar.com/search/flights/"
		strMeio = self.origem + '/' + self.destino + '/' + self.dia.isoformat()
		strFim = "1/0/0" # O Preco pesquisado é de um adulto
		retorno += "oneWay/" + strMeio + '/' + strFim

		return retorno

	def __crawler(self,url):
		"""Funcao que retorna o html como uma string"""
		try:
			print("Fazendo o craw url")
			print(url)
			browser = spynner.Browser()
			browser.load(url)
			try:
				browser.wait_page_load()
			except:
				pass
			retorno = browser.html.encode("utf8","ignore")
			browser.close()
			return retorno
		except:
			raise
		

	def __preencherDados(self): 
		"""Preenche os dados da cia aerea do preco e da data da ultima pesquisa"""
		#ToDo: Deve ser bem testado para que seja analisado todos os cenarios de erros
		#Por enquanto a abordagem eh pegar apenas o primeiro resultado da decolar. Futuramente podemos refinar isso
		#Por enquanto apenas o preco em real eh analizar		
		try:
			s = self.__crawler(self.__getUrl())
			file = open("t2.txt","w")
			file.write(s)
			file.close()
			soup = BeautifulSoup(s)
			Itinerary0 = soup.find('div',{'id':'Itinerary_0'} )
			self.__cia = Itinerary0.find('div',{'id':'CompressItinAirlineName'}).find('strong').contents[0].strip() #a cia de ida e volta sao iguais
			self.__horaSaidaIda = Itinerary0.find('div',{'class':'salida'}).find('strong').contents[0].strip()
			self.__horaChegadaIda = Itinerary0.find('div',{'class':'llegada'}).find('strong').contents[0].strip()
		
			precoLocal0 = Itinerary0.find('div',{'id':'CompressItinPriceLocalAmount'}).find('strong').contents[0].strip() #Preco na moeda local, geralmente real total
			self.__preco = precoLocal0.split(' ')[1]
			self.__ultimaPesquisa = datetime.now()
			return 1
		except:
			self.__ultimaPesquisa = datetime.now()
			return 0

	def pesquisar(self):
		"""Realiza a pesquisa do voo"""
		
		if self.cod == 0:
			print("Nao ha mais voo/n")
			return 0
		else:
			#Informa que o voo esta sendo pesquisado
			try:
				query = "UPDATE Voo SET  Pesquisando = 1, UltimaPesquisa = Now() where cod = %d;" % (self.cod)  
				self.bd.executar(query)
				#self.bd.executar("commit;");
			except:
				print("Erro para persistir os dados ")
				return 0
			finally:
				self.bd.desconectar()

			if self.__preencherDados() == 1:
				try:
					query = "UPDATE Voo SET Preco  = '%s',Cia = '%s',HoraSaidaIda = '%s',HoraChegadaIda = '%s', UltimaPesquisa = '%s', Pesquisando = 0 where cod = %d;" % (self.__preco, self.__cia, self.__horaSaidaIda, self.__horaChegadaIda,self.__ultimaPesquisa, self.cod)  
		#print(query)
					self.bd.executar(query)
				except:
					print("Erro para persistir os dados ")
				finally:
					self.bd.desconectar() 
			else:
				print("\nOcorreu um erro no crawl")
				try:
					query = "UPDATE Voo SET NumErro = %d, UltimaPesquisa = '%s', Pesquisando = 0 where cod = %d;" % (self.numErro + 1, self.__ultimaPesquisa, self.cod)  
		#print(query)
					self.bd.executar(query)
				except:
					print("Erro para persistir os dados ")
				finally:
					self.bd.desconectar()
			return 1
	
		


if __name__ == '__main__':
	voo = Voo()
	if (voo.pesquisar() == 0):
		print("$")
	else:
		print("&%s#"%str(voo.cod))

		
