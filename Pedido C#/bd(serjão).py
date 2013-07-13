import MySQLdb
class BD(object):
    """classe que separa a camada de banco de dados do da camada logica da aplicacao"""
    def __init__(self):
        self.__con = None
        self.__cursor = None
        self.__servidor = ""
        self.__usuario = ""
        self.__senha = ""
        self.__db = ""
        self.__conectado = False
    def recebeDadosConexao(self, serv, user, senha, datab):
        """metodo que recebe os dados de conexao ao BD"""
        self.__servidor = serv
        self.__usuario = user
        self.__senha = senha
        self.__db = datab
    def __conectar(self):
        """metodo que conecta ao BD"""
        if self.__conectado:
            return True
        try:
            self.__con = MySQLdb.connect(self.__servidor, self.__usuario, self.__senha)
            self.__con.select_db(self.__db)
            self.__cursor = self.__con.cursor()
            self.__conectado = True
        except:
            print("Erro ao conectar com o Banco de Dados")
            return False
    def desconectar(self):
        """metodo que desconecta do BD"""
        if self.__conectado:
            pass
        self.__conectado = False
        pass
    def __formata(self,arg):
        if type(arg) == str:
            return "'" + arg + "'"
        return arg
    def select(self, tabela, dict):
        """metodo que usa o select do SQL tabela->string dict->dicionario(string,string)"""
        if self.__conectado == False:
            self.__conectar()
        if self.__conectado == True:
            str = "SELECT * FROM " + tabela + " WHERE (1=1"
            it = dict.keys()
            for i in it:
                str = str + " " + "AND " + i + "=" + self.__formata(dict[i])
            str += ");"
            try:
                self.__cursor.execute(str)
                rs = self.__cursor.fetchall()
                return rs
            except:
                return None
    def update(self, tabela, dict, dict2):
        """metodo que usa o update do SQL tabela->string dict->dicionario(string,string) que contem os atributos a ser modificados dict2->dicionario(string,string) que contem o filtro para quem se quer que modifique"""
        if self.__conectado == False:
            self.__conectar()
        if self.__conectado == True:
            str = "UPDATE " + tabela + " SET "
            it = dict.keys()
            bool = False
            for i in it:
                if bool:
                    str = str + ", "
                else:
                    bool = True
                str = str + i + "=" + self.__formata(dict[i])
            str = str + " WHERE (1=1"
            it = dict2.keys()
            for i in it:
                str = str + " " + "AND " + i + "=" + self.__formata(dict2[i])
            str += ");"
            try:
                self.__cursor.execute(str)
                b = self.__cursor.fetchall()
                return b
            except:
                return None
    def inserir(self, tabela, dict):
        """metodo que usa o insert do SQL tabela->string dict->dicionario(string,string) que contera os dados a ser inseridos nos respectivos campos"""
        if self.__conectado == False:
            self.__conectar()
        if self.__conectado == True:
            str = "INSERT INTO " + tabela + " ("
            it = dict.keys()
            bool = False
            for i in it:
                if bool:
                    str = str + ", "
                else:
                    bool = True
                str = str + i
            str = str + ") VALUES ("
            bool = False
            for i in it:
                if bool:
                    str = str + ", "
                else:
                    bool = True
                str = str + self.__formata(dict[i])
            str += ");"
            print(str)
            try:
                self.__cursor.execute(str)
                b = self.__cursor.fetchall()
                return b
            except:
                return None
    def remover(self, tabela, dict):
        """metodo que usa o delete do SQL tabela->string dict->dicionario(string,string) que contem os dados para filtrar quem deve ser removido"""
        if self.__conectado == False:
            self.__conectar()
        if self.__conectado == True:
            str = "DELETE FROM " + tabela + " WHERE (1=1"
            it = dict.keys()
            for i in it:
                str += " " + "AND " + i + "=" + self.__formata(dict[i])
            str += ")"
            try:
                self.__cursor.execute(str)
                b = self.__cursor.fetchall()
                return b
            except:
                return None