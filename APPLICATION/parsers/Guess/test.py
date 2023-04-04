import time
import sys, os
sys.path.append(os.getcwd()+'/APPLICATION')
from parsel import Selector
from selenium import webdriver
from selenium.webdriver.chrome.options import Options



URL = 'https://www.guessfactory.com/us/en/men/accessories/watches'
options = Options()
options.add_argument("--window-size=1920,1080");
options.add_argument("--disable-gpu");
options.add_argument("--proxy-bypass-list=*");
options.add_argument("--start-maximized");
options.add_argument("--headless");
dr = webdriver.Chrome(chrome_options=options)
dr.get(URL)

#sel = Selector(text=dr.page_source)
print(dr.page_source)


