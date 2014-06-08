#!/usr/bin/env python2.7
# -*- coding: UTF-8 -*-
#
import sys
import os
import codecs
import logging
from optparse import OptionParser


BD_CONF = {"h": "localhost", "u": "cetres_bolco",
           "p": "girafaganso", "b": "cetres_bolco"}

def carregar_arquivo(arquivo):
    resultado = []
    with codecs.open(arquivo + ".resu", "r", "utf-8") as fp:
        for d in fp.readlines():
            arr = d.split(";")
            resultado.append(arr[:2] + map(float, arr[2:]))
    return resultado

def atualizar_banco(dados, data):
    global BD_CONF
    paises = dict()
    jogos=[]
    import MySQLdb
    try:
        conn = MySQLdb.connect (host = BD_CONF["h"],
                     user = BD_CONF["u"],
                     passwd = BD_CONF["p"],
                     db = BD_CONF["b"],
                     use_unicode=True)
        conn._transactional = 1;
        cursor = conn.cursor()
        cursor.execute("SELECT idpaises cod,Nome nome FROM paises")
        result_set = cursor.fetchall()
        for row in result_set:
            if row[1].strip() == u'B\xf3snia':
                pais = u'B\xf3snia-Herzegovina'
            elif row[1].strip() == u'Ir\xe3':
                pais = u'Ir\xe3o'
            elif row[1].strip() == u'Estados Unidos':
                pais = u'EUA'
            elif row[1].strip() == u'Cor\xe9ia do Sul':
                pais = u'Coreia do Sul'
            else:
                pais = row[1].strip()
            paises[pais] = row[0]
        #print paises
        #print dados
        logging.debug("Paises identificados: %d" % len(paises))
        cursor.execute("DELETE FROM bwin WHERE bw_data=%s",(data))
        for d in dados:
            try:
                #logging.debug("Identificando os paises")
                if not paises.has_key(d[0]):
                    logging.error("Pais nao identificado - %s" % d[0])
                if not paises.has_key(d[1]):
                    logging.error("Pais nao identificado - %s" % d[1])
                t1=paises[d[0]]
                t2=paises[d[1]]
            except KeyError as e:
                logging.error("Erro, pais invalido %d: %s" % (e.args[0], e.args[1]))
                continue
            cursor.execute("""SELECT jo_codigo,jo_time1 
                   FROM jogos WHERE (jo_time1=%s AND jo_time2=%s) 
                     OR (jo_time2=%s AND jo_time1=%s)""", (t1,t2,t1,t2))
            row = cursor.fetchone()
            if row == None:
                logging.error("Erro: jogo nao identificado - %s vs %s" % (t1,t2))
                continue
            jogo=int(row[0])
            logging.debug("Jogo %s" % jogo)
            if (jogos.count(jogo) > 0):
                logging.warn("ATENCAO: Jogo repetido. Segunda fase?")
            else:
                jogos.append(jogo)
                if int(row[1])==int(t1):
                    p1=d[2]
                    p2=d[4]
                else:
                    p1=d[4]
                    p2=d[2]
                pe=d[3]
                cursor.execute ("""INSERT INTO bwin 
                  (bw_jogo,bw_data,bw_time1,bw_time2,bw_empate) 
                  VALUES (%s,%s,%s,%s,%s)""",(jogo,data,p1,p2,pe))
        conn.commit();
    except MySQLdb.Error as e:
        logging.error("Error %d: %s" % (e.args[0], e.args[1]))
        sys.exit (1)
    except Exception as inst:
        logging.error("Erro na conversao  - " + str(inst))
        raise
        conn.rollback()

    conn.close();

if __name__ == '__main__':
    usage = u"%prog [opcoes] arquivo"
    parser = OptionParser(usage=usage)
    parser.add_option("-n", "--nao-atualiza", action="store_false", dest="atualiza",
                  default=True, help=u"Nao altera o banco de dados")
    parser.add_option("-v", "--verbose", action="store_true", dest="verbose",
                  help=u"Modo distrambelhado ;)")
    (options, args) = parser.parse_args()

    try:
        if options.verbose:
            logging.basicConfig(level=logging.DEBUG)
        else:
            logging.basicConfig(level=logging.WARN)
        logging.debug("Logging configurado")
        if len(args) != 1:
            parser.error(u"Favor especificar o arquivo")
        if not os.path.exists(args[0] + ".resu"):
            parser.error(u"Arquivo nao encontrado")
        dados = carregar_arquivo(args[0])
        if options.atualiza:
            atualizar_banco(dados, args[0][5:13])
    except:
        raise