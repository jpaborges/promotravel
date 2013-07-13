# -*- coding: utf-8 -*-
import twitter
import oauth2
from datetime import datetime

class RedeSocial (object):
  def __init__(self, consumer_key = 'e1EpZltQfOIdzcTJGNisfA', consumer_secret = 'DIHCUG4ORoUCTT8GEQntRyZmOMiHw2Ieg5DGusaps', 
  access_token_key = '607300060-KjWP0pbQiZTTG0npiklHe8hM7Yk4myOrv4LziEOA', access_token_secret = '4ioOiujPRwYcn8Rknz8MNkfydDzCiCRHCHYKGJOuWw'):
    self.consumer_key = consumer_key
    self.consumer_secret = consumer_secret
    self.access_token_key = access_token_key
    self.access_token_secret =access_token_secret
    self.tweet = twitter.Api(consumer_key, consumer_secret, access_token_key, access_token_secret)
    self.conteudo = ""
  
  def fazerLog(self, mensagem = ""):
    nomeArquivo = "log.txt"
    try:
      ler = open(nomeArquivo,"r")
      self.conteudo = ler.read()
      ler.close()
    except:
      print ("Erro ao LER o arquivo\n")
    
    try:
      escrever = open(nomeArquivo,"w")
      self.conteudo = self.conteudo + "\n" + mensagem
      escrever.write(self.conteudo)
      escrever.close()
    except:
      print ("Erro ao ESCREVER no arquivo\n")
  
  def postar(self, mensagem = ""):
    try:
      getVerify = self.tweet.VerifyCredentials()
      getPublic = self.tweet.GetPublicTimeline()
      print(getVerify)
      print(getPublic)
      self.tweet.PostUpdate(mensagem)
      return True
    except:
      hoje = datetime.now()
      self.fazerLog(str(hoje.day) + "." + str(hoje.month) + "." + str(hoje.year) + ": Não foi possivel publicar: " + mensagem)
      return False

a = RedeSocial()
a.postar("teste")