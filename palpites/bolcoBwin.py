#!/usr/bin/env python2.7
# -*- coding: UTF-8 -*-
#
#

import os
import re
import logging
import time
import codecs
from urllib import urlencode
import HTMLParser
from optparse import OptionParser

import mechanize
from BeautifulSoup import BeautifulSoup

def time_normalize(time):
    if time == u"Bósnia-Herzegovina":
        return "Bósnia"
    else:
        return time

def download(caminho):
    br = mechanize.Browser()
    logging.debug("Iniciando a conexao com o Bwin")
    br.open("https://sports.bwin.com/pt/sports")
    logging.debug("Aguardando 5 segundos...")
    time.sleep(5)
    logging.debug("Requisitando a pagina com as cotacoes do mundial")
    data = { 'sportId': '4', 
             'leagueIds': '20775,36088,36089,36090,36091,36092,36093,36094,36095,39372',
             'page': '0'
           }
    response1 = br.open("https://sports.bwin.com/pt/sports/indexmultileague", urlencode(data))
    assert br.viewing_html()
    logging.debug(br.title())
    logging.debug(response1.geturl())
    nomeArq = 'bwin-' + time.strftime('%Y%m%d%H%M%S')
    if caminho:
        nomeArq = os.path.join(caminho,nomeArq)
    with open(nomeArq + ".head", 'w') as fp:
        fp.write(str(response1.geturl())+"\n")
        fp.write(str(response1.info()))
    with open(nomeArq + ".body", 'w') as fp:
        fp.write(str(response1.read()))
    return nomeArq

def processa(arquivo):
    h = HTMLParser.HTMLParser()
    base = BeautifulSoup(open(arquivo + '.body'), convertEntities=BeautifulSoup.HTML_ENTITIES)
    fp = codecs.open(arquivo + '.resu' , 'w', 'utf-8')
    for tr_jogo in base.findAll("tr", {"class": "col3 three-way"}):
        info = tr_jogo.findAllNext("span")[:6]
        o1 = info[0].text
        t1 = h.unescape(info[1].text)
        dr = info[2].text
        o2 = info[4].text
        t2 = h.unescape(info[5].text)
        logging.debug(u"(%s) %s (%s) %s (%s)" % (o1,t1,dr,t2,o2))
        fp.write('%s;%s;%s;%s;%s\n' % (t1,t2,o1,dr,o2))
    fp.close()

if __name__ == '__main__':
    usage = u"%prog [opcoes]"
    parser = OptionParser(usage=usage)
    parser.add_option("-d", "--download", action="store_true", dest="download",
                  default=False, help=u"Realiza o download apenas da pagina")
    parser.add_option("-c", "--caminho", dest="caminho", default=None,
                  help=u"Caminho onde os arquivos serao trabalhados")
    parser.add_option("-a", "--arquivo", dest="arquivo", default=None,
                  help=u"Arquivo para leitura da fonte HTML. Nao havera download")
    parser.add_option("-u", "--update", action="store_true", dest="update",
                  default=False, help=u"Atualiza banco de dados")
    parser.add_option("-v", "--verbose", action="store_true", dest="verbose",
                  help=u"Modo distrambelhado ;)")
    (options, args) = parser.parse_args()

    try:
        if options.verbose:
            logging.basicConfig(level=logging.DEBUG)
        else:
            logging.basicConfig(level=logging.WARN)
        logging.debug("Logging configurado")
        if options.caminho and not os.path.exists(options.caminho):
            parser.error(u"Caminho nao encontrado - %s" % options.caminho)
        if options.arquivo:
            arquivo = options.arquivo.rstrip(".body")
            if options.caminho:
                if not os.path.isdir(options.caminho):
                    parser.error(u"Caminho nao eh um diretorio - %s" % options.caminho)
                arquivo = os.path.join(options.caminho, os.path.basename(arquivo))
            if not os.path.exists(arquivo + '.body'):
                parser.error(u"Nao foi possivel localizar o arquivo - %s.body" % arquivo)
        else:
            arquivo = download(options.caminho)
        if not options.download:
            logging.debug("Iniciando o processamento do arquivo")
            processa(arquivo)
        if options.update:
            import bolcoBwinProcess
            dados = bolcoBwinProcess.carregar_arquivo(arquivo)
            data = os.path.basename(arquivo)[5:13]
            bolcoBwinProcess.atualizar_banco(dados, data)
    except:
        raise
