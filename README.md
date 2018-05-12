[![codebeat badge](https://codebeat.co/badges/e9f27ba5-84a0-4dd3-8430-7390f01093cd)](https://codebeat.co/projects/github-com-thedevfromker-crypto_exchange-master)


# crypto_exchange
Open-source cryptocoin exchange

# Web-site screen
![Index screenshot](https://i.imgur.com/3hCg2T8.png)
- [Other immage here](https://imgur.com/a/gGP6zjK)

# Telegram chat screen
![Telegram alert sample](https://i.imgur.com/OS86Ji2.png)

# Features
- Alerts in Telegram
- Delete deal data with DB
- XMR, BTC, LTC, DASH and ETH payment check
- Always fresh courses (with exchange commision)
   - Support fiat types: AUD, BRL, CAD, CHF, CLP, CNY, CZK, DKK, EUR, GBP, HKD, HUF, IDR, ILS, INR, JPY, KRW, MXN, MYR, NOK, NZD, PHP, PKR, PLN, RUB, SEK, SGD, THB, TRY, TWD, ZAR 
   - Support more 500 crypto to make pair.: BTC, ETH, XMR, DASH, LTC... [More here](https://api.coinmarketcap.com/v2/listings/)
- Responsible design)

# Info
- User can see info with order if he only entered `sec. id`
- To deals "Fiat-Crypto" (Ex. CZK -> BTC) in `TX ID` must paste: "Payed" after payment
- Edit you data in settings.php

# How to start with Telegram-bot alert?
- Write to https://telegram.me/BotFather
- And receive bot-tocken (Ex. 563755814:AAHnd7SCiYVg2Nx02p1tqKsfkBD0VEUzvPY) <- $bot_token
- Write to https://telegram.me/FalconGate_Bot message: `/get_my_id` <- $ch_id 
- Find bot with name (you set name) and send: `/start` to he

# How to add pair?
SQL command: ```INSERT INTO `pair`(`name`, `f_sk`, `t_sk`, `d_type`) VALUES ("","","","")```

Example: ```INSERT INTO `pair`(`name`, `f_sk`, `t_sk`, `d_type`) VALUES ("Monero -> Sberbank","XMR","RUB","c-f")```

   - "Monero -> Sberbank" - pair name
   - "XMR" - first pair symbol
   - "RUB" - second pair symbol
   - "c-f" - **C**rypto-**F**iat deal type because we send XMR to receive RUB
      - If you use for example: Sberbank -> Bitcoin set `d_type` -> `f-c` **F**iat-**C**rypto deal
      - And `f_sk` -> "RUB"
      - `t_sk` -> "BTC"
 

# Setup
- Import .sql
- Edit `include/settings.php`


Admin-panel is coming...
