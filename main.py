import os
import sqlite3
import requests
import sys

import requests
import urllib3
import time
import requests

conn = sqlite3.connect('mydatabase.db')

# İmleç oluşturma
cursor = conn.cursor()
def sozluk_ara(kelime):
    try:
        headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'
        }
        response = requests.get('https://sozluk.gov.tr/gts', params={"ara": kelime}, headers=headers, timeout=1)
        # response.raise_for_status()
        a = response.json()
    except requests.exceptions.RequestException as e:
        a = e

    return a

# Hata durumunda yapılacak işlemler (örneğin, yeniden deneme, kullanıcıya bildirme)


def word_insert_onefile():
    alphabet = "abcçdefghIİjklmnoöprsştuüvyz"
    main = open('all.txt', "w", encoding="utf-8")
    for i in alphabet:
        text = open('alfabe/' + i + '.txt', "r", encoding="UTF-8")
        main.write(text.read())
        
def word_miner():
    w = open("all.txt", "r", encoding='utf-8').read().split('\n')
    filtered_list = [item for item in w if item != ""]
    xsa = len(w)
    asd = 1
    sesli_liste = ["a", "e", "ı", "i", "u", "ü", "o", "ö"]
    grand_zamani = time.perf_counter()
    for i in filtered_list:
        baslangic_zamani = time.perf_counter()
        sesliler = ""
        for m in i:
            if m.lower() in sesli_liste:
                sesliler += m.lower()
        hece = len(sesliler)
        ms = sozluk_ara(i)
        if isinstance(ms, list):
            qw = ''
            try:
                if isinstance(ms[0]["anlamlarListe"][0]["anlam"], list):
                    for s in ms[0]["anlamlarListe"][0]["anlam"]:
                        qw += s
                    text = qw
                else:
                    text = ms[0]["anlamlarListe"][0]["anlam"]
                text = text.replace('► ', '')
                bitis_zamani = time.perf_counter()
                altime = (bitis_zamani - baslangic_zamani) * 1000
                proctime = bitis_zamani - grand_zamani
                stat = "[ " + str(int(altime)) + " / " + str(int(proctime)) + " ][ " + str(xsa) + ' / ' + str(
                    asd) + " ]"

                print(stat + "\n" + i + " :-: " + text)
                asd += 1
            except IndexError:
                open('error.txt', 'r+', encoding="utf-8").write(i).close()

        else:
            text = 'f'
        cursor.execute("INSERT INTO kelime (kelime, sesli, anlam, hece) VALUES (?, ?, ?, ?)", (i, sesliler, text, hece))
        conn.commit()
    conn.close()