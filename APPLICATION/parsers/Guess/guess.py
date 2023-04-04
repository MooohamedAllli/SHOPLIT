import sys, os
sys.path.append(os.getcwd()+'/APPLICATION')
import guess_helpers

#Male watches scraping
SUB_CATEGROY = 101
URL101 = "https://www.guessfactory.com/us/en/men/accessories/watches" 
products101 = guess_helpers.guess_parser(URL101,SUB_CATEGROY)

#Female watches scraping
SUB_CATEGROY = 102
URL102 = "https://www.guessfactory.com/us/en/women/accessories/watches" 
products102 = guess_helpers.guess_parser(URL102,SUB_CATEGROY)

#Male sunglasses scraping
SUB_CATEGROY = 201
URL201 = "https://www.guessfactory.com/us/en/men/accessories/sunglasses" 
products201 = guess_helpers.guess_parser(URL201,SUB_CATEGROY)

#Female sunglasses scraping
SUB_CATEGROY = 202
URL202 = "https://www.guessfactory.com/us/en/women/accessories/sunglasses" 
products202 = guess_helpers.guess_parser(URL202,SUB_CATEGROY)

#Male Wallets scraping
SUB_CATEGROY = 301
URL301 = "https://www.guessfactory.com/us/en/men/accessories/wallets-and-bags" 
products301 = guess_helpers.guess_parser(URL301,SUB_CATEGROY,'Wallet')

#Female Wallets scraping
SUB_CATEGROY = 302
URL302 = "https://www.guessfactory.com/us/en/women/accessories/wallets-and-wristlets"
products302 = guess_helpers.guess_parser(URL302,SUB_CATEGROY,'Wallet')

