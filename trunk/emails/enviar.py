#!/usr/bin/env python2.7
# -*- coding: UTF-8 -*-

from pysimplesoap.client import SoapClient
client = SoapClient(wsdl="http://www.bolco.com.br/ws/bolco2010.wsdl")
response = client.ObterEnvioEmail(dataInicio="")
print response