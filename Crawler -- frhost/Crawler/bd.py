import urllib2, urllib
import base64
from datetime import date, datetime
import json
class BancoDados():
	"""classe que separa a camada de banco de dados do da camada logica da aplicacao"""
	def __init__(self,servidor = 'mysql1.alwaysdata.com',usuario = '46507_promo',senha = 'BIDord$',banco = 'promotravel_bd'):
		self.con = None
		self.cursor = None
		self.__servidor = servidor
		self.__usuario = usuario
		self.__senha = senha
		self.__db = banco
		self.conectado = False

	def __mandarOPost(self,query):
		path='http://promotravel.com.br/ws.php'    #the url you want to POST to
		query = "3&" + query
		req=urllib2.Request(path, query)
		req.add_header("Content-type", "application/x-www-form-urlencoded")
		page=urllib2.urlopen(req).read()
		return page

	def desconectar(self):
		"""metodo que desconecta do BD"""
		if self.conectado:
			self.conectado = False
   
	def executar(self, query):
		"""metodo que executa uma query no banco de dados"""
		try:
			criptografado = base64.b64encode(query)
			rs = self.__mandarOPost(criptografado)
			if ((query[0] == 's') or (query[0] == 'S')):
				#Eh um select
				rs = json.loads(rs)
				l = []
				[l.extend([k.values()]) for k in rs]
				rs = l
			return rs
		except:
			raise
			return None
