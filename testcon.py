import requests
import logging
import http.client as http_client
from requests.packages.urllib3.exceptions import InsecureRequestWarning

# HTTP isteklerini günlüğe kaydetmek için logging yapılandırması
"""http_client.HTTPConnection.debuglevel = 1
logging.basicConfig()
logging.getLogger().setLevel(logging.DEBUG)
requests_log = logging.getLogger("requests.packages.urllib3")
requests_log.setLevel(logging.DEBUG)
requests_log.propagate = True

# InsecureRequestWarning uyarısını kapatın
requests.packages.urllib3.disable_warnings(InsecureRequestWarning)
"""
