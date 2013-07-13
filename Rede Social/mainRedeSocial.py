# -*- coding: utf-8 -*-
from RedeSocial import RedeSocial
from bd import BancoDados
from datetime import datetime
from bd import BancoDados


def stringPublicacao(ida, volta, cia, origem, preco, destino, aeroportos):
  '''Recebe os parametros na mesma ordem dos valores que são retornados na classe BancoDados e retorna uma string pronta para ser publicada'''
  dataIda = ida.split("-")[2] + "/" +  ida.split("-")[1] + "/" +  ida.split("-")[0]
  origem2 = ""
  destino2 = ""
  for parte in aeroportos:
    if origem in parte:
      origem2 = parte.split("(")[0].split("/")[0]
    elif destino in parte:
      destino2 = parte.split("(")[0].split("/")[0]
  if(volta == 'None'):
    return ("R$: " + preco + " " + origem2 + " -> " + destino2 + " Ida: " + dataIda + " Cia: " + cia).replace("  "," ")
  else:
    dataVolta =  volta.split("-")[2] + "/" + volta.split("-")[1] + "/" + volta.split("-")[0]
    return ("R$: " + preco + " " + origem2 + " -> " + destino2 + " Ida: " + dataIda + " Volta: " + dataVolta + " Cia: " + cia).replace("  "," ")

def publicaDefinitivamente(query, banco, rede ,baratoOuProcurado, aeroportos):
  maisBaratas = banco.executar(query)
  if(maisBaratas != None):	
    rede.postar("Confira as passagens mais " + baratoOuProcurado)
    for i in maisBaratas:
      b = stringPublicacao (str(i[0]), str(i[1]) , str(i[2]),str(i[3]) ,str(i[4]) , str(i[5]), aeroportos)
      postado = False;
      j = 0
      while (not postado):
	if (rede.postar(b)):
	  postado = True
	elif (j == 20):
	  postado = True
	j += 1
	print(j)
  else:
    print("Erro ao pegar as passagens mais "+ baratoOuProcurado)


def main():
  banco = BancoDados()
  
  hoje = "'" + str(datetime.now().year)+ "-"  + str(datetime.now().month) + "-" + str(datetime.now().day) + "'"
  
  query = ""
  
  aeroportos = ["Alta Floresta (AFL)" ,
		"Altamira (ATM)" ,
		"Aracaju (AJU)" ,
		"Araguaína (AUX)" ,
		"Araraquara (AQA)" ,
		"Araxá (AAX)" ,
		"Araçatuba (ARU)" ,
		"Barreiras (BRA)" ,
		"Bauru (JTC)" ,
		"Belo Horizonte / Confins Int'l (CNF)" ,
		"Belo Horizonte / Pampulha (PLU)" ,
		"Belo Horizonte / Todos os Aeroportos (BHZ)" ,
		"Belém (BEL)" ,
		"Boa Vista (BVB)" ,
		"Bonito (BYO)" ,
		"Brasília (BSB)" ,
		"Cacoal (OAL)",
		"Campinas / Viracopos (VCP) " ,
		"Campo Grande (CGR) " ,
		"Carajás (CKS)" ,
		"Cascavel (CAC)" ,
		"Caçador (CFC)" ,
		"Chapecó (XAP)" ,
		"Comandatuba (UNA)" ,
		"Corumbá (CMG)" ,
		"Criciúma (CCM)" ,
		"Cruzeiro do Sul (CZS)" ,
		"Cuiabá (CGB)" ,
		"Curitiba (CWB)" ,
		"Dourados (DOU)" ,
		"Erechim (ERM)" ,
		"Fernando de Noronha (FEN)" ,
		"Florianópolis (FLN)" ,
		"Fortaleza (FOR)" ,
		"Foz do Iguaçu (IGU)" ,
		"Franca (FRC)" ,
		"Goiânia (GYN)" ,
		"Gov. Valadares (GVR)" ,
		"Guarapuava (GPB)" ,
		"Ilhéus (IOS)" ,
		"Imperatriz (IMP)" ,
		"Ipatinga (IPN)" ,
		"Itaituba (ITB)" ,
		"Ji-Paraná (JPR)" ,
		"Joaçaba (JCB)" ,
		"Joinville (JOI)" ,
		"João Pessoa (JPA)" ,
		"Juiz de Fora (JDF)" ,
		"Lençóis (LEC)" ,
		"Londrina (LDB)" ,
		"Macapá (MCP)" ,
		"Macaé (MEA)" ,
		"Maceió (MCZ)" ,
		"Manaus (MAO)" ,
		"Marabá (MAB)" ,
		"Maringá (MGF)" ,
		"Marília (MII)" ,
		"Minacu (MQH)" ,
		"Montes Claros (MOC)" ,
		"Natal (NAT)" ,
		"Navegantes (NVT)" ,
		"Palmas (PMW)" ,
		"Parintins (PIN)" ,
		"Passo Fundo (PFB)" ,
		"Patos de Minas (POJ)" ,
		"Pelotas (PET)" ,
		"Petrolina (PNZ)" ,
		"Porto Alegre (POA)" ,
		"Porto Seguro (BPS)" ,
		"Porto Velho (PVH)" ,
		"Presidente Prudente (PPB)" ,
		"Recife (REC)" ,
		"Ribeirão Preto (RAO)" ,
		"Rio Branco (RBR)" ,
		"Rio Grande (RIG)" ,
		"Rio Verde (RVD)" ,
		"Rio de Janeiro / Galeão Int'l (GIG)" ,
		"Rio de Janeiro / Santos Dumont (SDU)" ,
		"Rio de Janeiro / Todos os Aeroportos (RIO)" ,
		"Rondonópolis (ROO)" ,
		"Salvador (SSA)" ,
		"Santa Maria (RIA)" ,
		"Santa Rosa (SRA)" ,
		"Santarém (STM)" ,
		"Santo Angelo (GEL)" ,
		"Sinop (OPS)" ,
		"São José do Rio Preto (SJP)" ,
		"São José dos Campos (SJK)" ,
		"São Luís (SLZ)" ,
		"São Paulo / Congonhas (CGH)" ,
		"São Paulo / Guarulhos Int'l (GRU)" ,
		"São Paulo / Todos os Aeroportos (SAO)" ,
		"Tabatinga (TBT)" ,
		"Tefe (TFF)" ,
		"Teresina (THE)" ,
		"Trombetas (TMT)" ,
		"Tucuruí (TUR)" ,
		"Uberaba (UBA)" ,
		"Uberlândia (UDI)" ,
		"Uruguaiana (URG)" ,
		"Vilhena (BVH)" ,
		"Vitória (VIX)" ,
		"Vitória Conquista (VDC)"]
		
  rede = RedeSocial('e1EpZltQfOIdzcTJGNisfA', 'DIHCUG4ORoUCTT8GEQntRyZmOMiHw2Ieg5DGusaps', '607300060-KjWP0pbQiZTTG0npiklHe8hM7Yk4myOrv4LziEOA','4ioOiujPRwYcn8Rknz8MNkfydDzCiCRHCHYKGJOuWw')

  query = "select DISTINCT  Origem, Destino, DiaIda, DiaVolta, Preco, Cia, Ocorrencia from Voo " + "where Preco <> 'NULL' and DiaIda BETWEEN " + hoje + " and '9999-12-31'" + "order by Ocorrencia, Preco, DiaIda, Origem, Destino, DiaVolta, Cia DESC limit 0,5"
  publicaDefinitivamente(query,banco,rede,"Baratas",aeroportos)
  
  query = "select DISTINCT Origem, Destino, DiaIda, DiaVolta, Preco, Cia from Voo " + "where Preco <> 'NULL' and DiaIda BETWEEN " + hoje + " and '9999-12-31'" + "order by Preco, DiaIda, Origem, Destino, DiaVolta, Cia ASC limit 0,5"
  publicaDefinitivamente(query,banco,rede,"Procuradas",aeroportos)
  

    
main()