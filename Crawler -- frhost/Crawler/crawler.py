#-*-coding:utf-8-*-
import spynner
from datetime import timedelta, date,datetime
from BeautifulSoup import BeautifulSoup
from bd import BancoDados
import sys
import time

class Voo:
	def __init__(self):
		self.bd = BancoDados()
		self.cod = 0 #No banco de dados os voos serao identificados por um cod para nao ter voos repitidos
		self.origem = "SSA"
		self.destino = "REC"
		self.ida = datetime(1,1,1)
		self.volta = datetime(1,1,1)
		self.numErro = 0
		try:
			#query = "SELECT Cod, Origem, Destino, DiaIda, DiaVolta, NumErro from Voo where (pesquisando = 0 or (pesquisando = 1 and UltimaPesquisa < subtime(now(),'12:00'))) and UltimaPesquisa <  subtime(now(),'6:00') and DiaIda > adddate(now(),3) and DiaVolta > adddate(now(),3) and Ocorrencia > 0 and NumErro < 5 order by prioridade desc limit 1;"#TODO: Ver o tempo exato ---A cada 6h,no maximo 5 erros
			query = "Select PegarVooAtomicamente();"
			voo = self.bd.executar(query)
			voo = voo[0][0].split('$')
			if (voo != None):
				self.cod = int(voo[0])
				self.origem = voo[1]
				self.destino = voo[2]
				self.ida = date(int(voo[3].split('-')[0]),int(voo[3].split('-')[1]),int(voo[3].split('-')[2]))
				try:

					self.volta = date(int(voo[4].split('-')[0]),int(voo[4].split('-')[1]),int(voo[4].split('-')[2]))
				except:
					
					self.volta = None
				self.numErro = int(voo[5])
		except:
			print("Erro para ler os dados \n")

			#raise
		finally:
			self.bd.desconectar() 

	
		
		'''Essa parte vai ser preenchida pelo crawler, por isso é private'''
		
		self.__preco = 0.01
		self.__cia = "Gol"
		self.__horaSaidaIda = "9:23"
		self.__horaChegadaIda = "10:10"
		self.__horaSaidaVolta = "9:23"
		self.__horaChegadaVolta = "10:10"
		self.__ultimaPesquisa = datetime(1,1,1)
		self.__status = 0 



	def __getUrl(self): 
		"""Retorna a url para fazer a pesquisa dessa passagem"""
		
		retorno = "http://www.decolar.com/search/flights/"
		strMeio = self.origem + '/' + self.destino + '/' + self.ida.isoformat()
		strFim = "1/0/0" # O Preco pesquisado é de um adulto

		if (self.volta == None):			
			retorno += "oneWay/" + strMeio + '/' + strFim
		else:
			retorno += "RoundTrip/" + strMeio + '/' + self.volta.isoformat() + '/' + strFim
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
			#file = open("t2.txt","r")
			#s = file.read()
			#file.close()
			soup = BeautifulSoup(s)
			if (self.volta == None):
				#Itinerary0 = soup.find('div',{'id':'Itinerary_0'} )
				self.__cia = soup.find('div',{'class':'airline-name'}).find('span').contents[0].strip() 
				self.__horaSaidaIda = soup.find('li',{'class':'leave'}).find('strong').contents[0].strip()
				self.__horaChegadaIda = soup.find('li',{'class':'arrive'}).find('strong').contents[0].strip()		
				self.__preco = soup.find('span',{'class':'price-amount'}).contents[0].strip()
				try:
					self.__preco = self.__preco.replace('.','')
					self.__preco = self.__preco .split(' ')[1]		
				except:
					pass
			else:
				#Itinerary0 = soup.find('div',{'id':'ItinBox_0'} )
				self.__cia = soup.find('div',{'class':'airline-name'}).find('span').contents[0].strip()#a cia de ida e volta sao iguais
				self.__horaSaidaIda = soup.find('li',{'class':'leave'}).find('strong').contents[0].strip()
				self.__horaChegadaIda = soup.find('li',{'class':'arrive'}).find('strong').contents[0].strip()
				self.__horaSaidaVolta = soup.find('div',{'class':'sub-cluster inbound'}).find('li',{'class':'leave'}).find('strong').contents[0].strip()
				self.__horaChegadaVolta = soup.find('div',{'class':'sub-cluster inbound'}).find('li',{'class':'arrive'}).find('strong').contents[0].strip()
				self.__preco = soup.find('span',{'class':'price-amount'}).contents[0].strip()
				try:
					self.__preco = self.__preco.replace('.','')
					self.__preco = self.__preco .split(' ')[1]		
				except:
					pass
			
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
			if self.__preencherDados() == 1:
				try:
					if (self.volta == None):
						query = "UPDATE Voo SET Preco  = %.2f,Cia = '%s',HoraSaidaIda = '%s',HoraChegadaIda = '%s', UltimaPesquisa = '%s', Pesquisando = 0 where cod = %d;" % (float(self.__preco), self.__cia, self.__horaSaidaIda, self.__horaChegadaIda,self.__ultimaPesquisa, self.cod)  
					else:
						query = "UPDATE Voo SET Preco  = %.2f,Cia = '%s',HoraSaidaIda = '%s',HoraChegadaIda = '%s', HoraSaidaVolta = '%s',HoraChegadaVolta = '%s',UltimaPesquisa = '%s', Pesquisando = 0 where cod = %d;" % (float(self.__preco), self.__cia, self.__horaSaidaIda, self.__horaChegadaIda, self.__horaSaidaVolta,self.__horaChegadaVolta,self.__ultimaPesquisa, self.cod)  

		#print(query)
					self.bd.executar(query)
				except:
					raise
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
					raise
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

		
