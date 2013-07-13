# -.- coding: utf-8 -.-
from threading import Thread, Condition
import commands
import Queue
import time
import sys, getopt
import errno,os,signal,subprocess
from datetime import datetime, timedelta

vetor = []
flag = 0
class ThreadCrawl(Thread):
	def __init__(self,caminho,num,modo,condicao):
		Thread.__init__(self)
		self.caminho = caminho
		self.num = num
		self.modo = modo
		self.condicao = condicao

	
	def run(self):
		global vetor
		global flag
		t = datetime.now()
		while (1):
			s = commands.getoutput(('python %s' % self.caminho))
			if s[len(s) - 1] == '$':
				self.condicao.acquire()
				flag = 1
				self.condicao.notifyAll()
				self.condicao.release()
				if self.modo == 1:
					break
				else:
					t2=datetime.now()
					print("Thread %d finalizou em %s Vai esperar 1min para executar de novo" % (self.num,str(t2-t)))
					time.sleep(60)
			elif s[len(s) - 1] == '#':
				try:
					aux = s.split('&')[1]
					vetor[self.num] += 1 
					print("Funcionou? %s" % aux)
				except:
					print("Pode te dado merda: %s" % s)	
			else:
				print("Pode te dado merda: %s" % s)
		t2=datetime.now()
		print("Thread %d finalizou em %s" % (self.num,str(t2-t)))



def main(argv):
	global vetor
	global flag
	flag = 0
	nThreads = 5
	modo = 1
	try:
		opts, args = getopt.getopt(argv,"hn:m:",["nthreads=","mode="])
	except getopt.GetoptError:
		print 'exec.py -n <Numero de threas> -m <0 para initerrupto e  1 para parar>'
		sys.exit(2)
	
	for opt, arg in opts:
		if opt == '-h':
			print 'exec.py -n <Numero de threas> -m <0 para initerrupto e 1 para parar>'
			sys.exit()
		elif opt in ("-n", "--nthreads"):
			nThreads = int(arg)
		elif opt in ("-m", "--mode"):
			modo = int(arg)

	t = [] #vetor thread
	condicao = Condition()
	contador = 0
	for i in range(nThreads):
		t += [ThreadCrawl("./crawler.py",i,modo,condicao)]
		vetor += [0]


	print("Iniciado")
	tempo = datetime.now()

	for i in range(nThreads):
		try:
			t[i].start()
		except RuntimeError:
			print("Deu um erro para iniciar a thread %d de novo" % i)

	if (modo == 1):
		#enquanto todas as threads nao terminaram, espere
		condicao.acquire()
		while(flag == 0):
			condicao.wait()	
		condicao.release()
		timesOut = 0	
		aux = 0
		while (contador < nThreads):
			aux =0	
			for i in range(nThreads):
				if (t[i].isAlive()):
					aux = 1#Tem threads vivas ainda
				else:
					contador += 1 	
					print ("Thread %d finalizou"%i)
			if (aux == 1):
				timesOut += 1
				time.sleep(1) #espera um segundo
		
			if (timesOut > 100): #ja passaram 100 segundos depois que alguma thread terminou
				print("Ocorreu um time out")				
				break

	
		tempo2 = datetime.now()
		print("Passaram %s para executar %d registros" % (str(tempo2-tempo),sum(vetor)))
		sys.exit(0)
	else:
		for i in range(nThreads):
			t[i].join()
		
if __name__ == "__main__":
	main(sys.argv[1:])
	

