# -.- coding: utf-8 -.-
from threading import Thread
import commands
import Queue
import time
import sys, getopt
import errno,os,signal,subprocess
from datetime import datetime, timedelta
#TODO: Esta acontecendo algum tipo de impasse tentar ver o que é...
vetor = []

class ThreadCrawl(Thread):
	def __init__(self,caminho,num,modo):
		Thread.__init__(self)
		self.caminho = caminho
		self.num = num
		self.modo = modo

	
	def run(self):
		global vetor
		t = datetime.now()
		while (1):
			s = commands.getoutput(('python %s' % self.caminho))
			if s[len(s) - 1] == '$':
				if self.modo == 1:
					break
				else:
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
		
		print(str(t2-t))



def main(argv):
	global vetor
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
	

	for i in range(nThreads):
		t += [ThreadCrawl("/home/jpaborges/Desktop/PromoTravel/Crawler/crawler.py",i,modo)]
		vetor += [0]


	print("Iniciado tenta resolver o impasse com lock")
	tempo = datetime.now()

	for i in range(nThreads):
		try:
			t[i].start()
		except RuntimeError:
			print("Deu um erro para iniciar a thread %d de novo" % i)

			

	for i in range(nThreads):
		t[i].join()

	
	tempo2 = datetime.now()
	print("Passaram %s para executar %d registros" % (str(tempo2-tempo),sum(vetor)))

if __name__ == "__main__":
	main(sys.argv[1:])
	

