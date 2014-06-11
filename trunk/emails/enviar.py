#!/usr/bin/env python2.7
# -*- coding: UTF-8 -*-

import os
import logging
from optparse import OptionParser

BD_CONF = {"h": "localhost", "u": "bolco",
           "p": "girafaganso", "b": "bolco"}

URL_WSDL = "http://www.bolco.com.br/ws/bolco2010.wsdl"


def obterLocal(conf):
    import MySQLdb
    
    
    

def obterRemoto(url):
    from pysimplesoap.client import SoapClient
    client = SoapClient(wsdl=url)
    response = client.ObterEnvioEmail(dataInicio="")
    print response


def envioAmazon(url):
    import boto


if __name__ == '__main__':
    usage = u"%prog [opcoes]"
    parser = OptionParser(usage=usage)
    parser.add_option("-l", "--local", action="store_true", dest="local",
                  default=False, help=u"Conecta no banco local")
    parser.add_option("-r", "--remoto", dest="remoto", default=None,
                  help=u"URL para leitura por SOAP")
    parser.add_option("-v", "--verbose", action="store_true", dest="verbose",
                  help=u"Modo distrambelhado ;)")
    (options, args) = parser.parse_args()

    try:
        if options.verbose:
            logging.basicConfig(level=logging.DEBUG)
        else:
            logging.basicConfig(level=logging.WARN)
        logging.debug("Logging configurado")
        if options.local:
            emails = obterLocal(BD_CONF)
        else:
            if options.remoto:
                emails = obterRemoto(options.remoto)
            else:
                emails = obterRemoto(URL_WSDL)
        envioAmazon(emails)
    except:
        raise