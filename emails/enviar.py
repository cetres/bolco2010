#!/usr/bin/env python2.7
# -*- coding: UTF-8 -*-

BD_CONF = {"h": "localhost", "u": "bolco",
           "p": "girafaganso", "b": "bolco"}


def obterLocal(conf):
    import MySQLdb
    
    

def obterRemoto(url):
    from pysimplesoap.client import SoapClient
    client = SoapClient(wsdl=url)
    response = client.ObterEnvioEmail(dataInicio="")
    print response


def envioAmazon(url):
    from pysimplesoap.client import SoapClient
    client = SoapClient(wsdl=url)
    response = client.ObterEnvioEmail(dataInicio="")
    print response


if __name__ == '__main__':
    usage = u"%prog [opcoes]"
    parser = OptionParser(usage=usage)
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
        if options.remoto:
            emails = obterRemoto("http://www.bolco.com.br/ws/bolco2010.wsdl")
        else:
            emails = obterLocal(BD_CONF)
        envioAmazon
    except:
        raise