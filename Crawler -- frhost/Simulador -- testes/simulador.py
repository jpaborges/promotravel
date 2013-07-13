#-*-coding:utf-8-*-
from bd import BancoDados
import random
from datetime import date, timedelta
import time

def inserirPesquisa(banco,email,origem,destino,precoE, diasIda, diasVolta):

	try:
		query = "INSERT INTO Pesquisa (Email_Cliente,Origem,Destino,PrecoEsperado) VALUES('%s','%s','%s',%f);" % (email,origem,destino,precoE)
		banco.executar(query)
	except:
		print("Erro ao inserir")
		raise
	finally:
		banco.desconectar()

	for d in diasIda:
		for d2 in diasVolta:
			try:
				query = "Call InserirDia('%s','%s','%s',%f,'%s','%s');" % (email,origem,destino,precoE, d,d2)
				banco.executar(query)
			except:
				print("Erro na procedure")
				raise
			finally:
				banco.desconectar()
		
def ativarPesquisa(banco,cod):
	
	try:
		query = "Call AtivarPesquisa(%d);" % cod
		banco.executar(query)
	except:
		print("Erro na procedure")
		return 0
	finally:
		banco.desconectar()
	
	return 1

def desativarPesquisa(banco,cod):
	try:
		query = "Call EncerrarPesquisa(%d);" % cod
		banco.executar(query)
	except:
		print("Erro na procedure")
		raise
	finally:
		banco.desconectar()

if __name__ == '__main__':
	b = BancoDados()
	menu = -1
	aeroportos =["ATM","AJU","AQA","BGX","JTC","BEL","CNF","PLU","BVB","BSB","CPV","VCP","CGR","CAW","CKS","CAU","CXJ","XAP","CMG","CCM","CGB","CWB","CZS","FEN","FLN","FOR","IGU","GYN","IOS","IMP","JPA","JOI","JDO","LDB","MEA","MCP","MCZ","MAO","MAB","MGF","MOC","MVF","NAT","NVT","PMW","PHB","PAV","PNZ","POO","PMG","POA","BPS","PVH","PPB","REC","RAO","RBR","GIG","SDU","SSA","STM","SJP","SJK","SLZ","MAE","CGH","GRU","TBT","TFF","THE","UDI","URA","UBT","URG","VIX"]
	
	while (menu != 0):
		menu = int(raw_input("Digite:\n1 para inserir pesquisa\n2 para ativar pesquisa\n3 para desativar pesquisa\n4 para inserir varias coisas\n6 Ativar as pesquisas de um determinado email\n0 para sair: "))
		if (menu == 1):
			email = raw_input("Digite o email: ")
			origem = raw_input("Digite a origem: ")
			destino = raw_input("Digite o destino: ")
			precoE = float(raw_input("Digite qnt espera pagar: "))
			nDias = int(raw_input("Numero de dias: "))
			dias = []
			for d in range(nDias):
				dia = raw_input("Digite o dia: 'yyyy-mm-dd' ")
				dias += [dia] 
			inserirPesquisa(b,email,origem,destino,precoE,dias)
		elif (menu == 2):
			cod = int(raw_input("Digite o codigo da pesquisa: "))
			ativarPesquisa(b,cod)
		elif (menu ==3):
			cod = int(raw_input("Digite o codigo da pesquisa: "))
			desativarPesquisa(b,cod)
		elif (menu ==4):
			qtd = int(raw_input("Quantidade que deseja inserir "));
			for i in range(qtd):
				r = random.randint(0,len(aeroportos) -1)
				email = "borgej2@rpi.edu"
				origem = aeroportos[r]
				r2 = random.randint(0,len(aeroportos) -1)
				while r == r2:
					r2 = random.randint(0,len(aeroportos) -1)
				destino = aeroportos[r2]
				precoE = 88.88
				dias = []
				for j in range(5):
					d = date.today()+timedelta(days=(random.randint(5,360)))
					dias += [d]
				dias2 = []
				for j in range(5):
					d = dias[j]+timedelta(days=(random.randint(5,360)))
					dias2 += [d]
					
				dias = [d.isoformat() for d in dias]
				dias2 = [d.isoformat() for d in dias2]
				inserirPesquisa(b,email,origem,destino,precoE,dias,dias2)
				print("%d of %d") % (i, qtd)

				#	for i in range(1,50):
				#while (ativarPesquisa(b,i) == 0):
				#	print("Esperando para tentar de novo")
				#	time.sleep(10)
		elif (menu ==5):
			file = open("i.sql","w")
			for i in range(50):
				r = random.randint(0,len(aeroportos) -1)
				email = "jp%d" %i
				origem = aeroportos[r]
				r2 = random.randint(0,len(aeroportos) -1)
				while r == r2:
					r2 = random.randint(0,len(aeroportos) -1)
				destino = aeroportos[r2]
				precoE = 130.50
				dias = []
				for j in range(10):
					d = date.today()+timedelta(days=(random.randint(5,15)))
					dias += [d.isoformat()]
				dias2 = []
				for j in range(10):
					d = date.today()+timedelta(days=(random.randint(16,30)))
					dias2 += [d.isoformat()]
				for d in dias:
					for d2 in dias2:
						s = "Insert Into Voo (Origem,Destino,DiaIda,DiaVolta,Ocorrencia) Values ('%s','%s','%s','%s',1);\n" % (origem,destino,d,d2)
						file.write(s)
			file.close()
		elif (menu ==6):
			email = raw_input("Digite o email: ")
			query = "Select Cod from Pesquisa where Status = 0 and Email_Cliente = '%s';" % (email)
			rs = b.executar(query)
			for cod in rs:
				c = int(cod[0])
				if (ativarPesquisa(b,c)):
					print("Pesquisa %d foi ativada" % c)
			

					


