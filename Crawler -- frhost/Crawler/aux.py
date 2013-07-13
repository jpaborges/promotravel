import spynner
from datetime import timedelta, date,datetime
from BeautifulSoup import BeautifulSoup
from bd import BancoDados
import sys
import time

class Voo:
	def __init__(self):
		self.cod = 0 #No banco de dados os voos serao identificados por um cod para nao ter voos repitidos
		self.origem = "SSA"
		self.destino = "REC"
		self.ida = datetime(1,1,1)
		self.volta = datetime(1,1,1)
		self.numErro = 0
		
		self.__preco = 0.01
		self.__cia = "Gol"
		self.__horaSaidaIda = "9:23"
		self.__horaChegadaIda = "10:10"
		self.__horaSaidaVolta = "9:23"
		self.__horaChegadaVolta = "10:10"
		self.__ultimaPesquisa = datetime(1,1,1)
		self.__status = 0 	
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
		

	def preencherDados(self,url): 
		"""Preenche os dados da cia aerea do preco e da data da ultima pesquisa"""
		#ToDo: Deve ser bem testado para que seja analisado todos os cenarios de erros
		#Por enquanto a abordagem eh pegar apenas o primeiro resultado da decolar. Futuramente podemos refinar isso
		#Por enquanto apenas o preco em real eh analizar		
		try:
			#s = self.__crawler(self.__getUrl())
			s = self.__crawler(url)
			file = open("t3.txt","w")
			file.write(s)
			file.close()
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
			raise
			self.__ultimaPesquisa = datetime.now()
			return 0

if __name__ == '__main__':
	voo = Voo()
	#voo.volta = None
	voo.preencherDados("http://www.decolar.com/shop/flights/search/roundtrip/CWB/MAO/2012-07-14/2012-07-29/1/0/0/")
