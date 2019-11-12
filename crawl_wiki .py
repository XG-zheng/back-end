
# coding: utf-8

# In[86]:


from requests import get
from filetype import guess
from os import rename
from os import makedirs
from os.path import exists
from json import loads
from contextlib import closing
import gzip
from bs4 import BeautifulSoup
import pymysql
import re

def getText(node):
    s = ""
    for item in node.find_all("p"):
        s += item.text
    return s
def Insert(pet):
    cursor = db.cursor()
    sql = "insert into wiki(category,full_name,shape,weight,alias,ori_country,height,life,base_info,feature,life_habit,advantages_disadvantages,feed_ways,select_skill,img) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
    cursor.execute(sql,(pet["category"],pet["full_name"],pet["shape"],pet["weight"],pet["alias"],pet["ori_country"],pet["height"],pet["life"],pet["base_info"],pet["feature"],pet["life_habit"],pet["advantages_disadvantages"],pet["feed_ways"],pet["select_skill"],pet["img"]))
    db.commit()
    
def crawl_mg(url,cate):
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36"}
    r = get(url,headers=headers)
    ret = r.content.decode('gb18030','ignore')
    soup = BeautifulSoup(ret, 'lxml')
    info = soup.find_all('div',class_="word")
    pet = {}
    info1 = soup.find("ul",class_="c1text3")
    lis = info1.find_all("li")
    pet["category"] = cate
    pet["shape"] = lis[4].a.string
    pet["weight"] = lis[6].a.string
    pet["full_name"] = lis[0].a.string
    pet["alias"] = lis[1].a.string
    pet["ori_country"] = lis[3].a.string
    pet["height"] = lis[5].a.string
    pet["life"]= lis[7].a.string
    pet["base_info"] = getText(info[0])
    pet["feature"] = getText(info[1])
    pet["life_habit"] = getText(info[2])
    pet["advantages_disadvantages"] = getText(info[3])
    pet["feed_ways"] = getText(info[4])
    pet["select_skill"] = getText(info[5])
    img = soup.find_all('a',class_='fancybox')
    pet["img"] = ""
    f = 1
    for item in img:
        if f == 0:
            pet["img"] +="&"
        else:
            f = 0
        pet["img"] += item.img["src"]
    Insert(pet)
    print(pet["full_name"])

def crawl_other(url,cate):
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36"}
    r = get(url,headers=headers)
    ret = r.content.decode('gb18030','ignore')
    soup = BeautifulSoup(ret, 'lxml')
    info = soup.find_all('div',class_="word")
    pet = {}
    info1 = soup.find("ul",class_="c1text3")
    pet["category"] = cate
    pet["shape"] = ""
    pet["weight"] = ""
    pet["full_name"] = ""
    pet["alias"] = ""
    pet["ori_country"] = ""
    pet["height"] = ""
    pet["life"]= ""
    pet["base_info"] = getText(info[0])
    pet["feature"] = getText(info[1])
    pet["life_habit"] = getText(info[2])
    pet["advantages_disadvantages"] = ""
    pet["feed_ways"] = getText(info[3])
    pet["select_skill"] = ""
    pet["full_name"] = soup.find("div",class_="c1text1").h1.string
    if pet["full_name"] == "":
        return 
    img = soup.find_all('div',class_='con1img')
    cur = info1.find(lambda e: e.name == 'li' and '英文名称' in e.text)
    if cur != None:
        pet["alias"] = cur.a.string
    cur = info1.find(lambda e: e.name == 'li' and '原 产 地' in e.text)
    if cur != None:
        pet["ori_country"] = cur.a.string
    cur = info1.find(lambda e: e.name == 'li' and '寿　　命' in e.text)
    if cur != None:
        pet["life"] = cur.a.string
    pet["img"] = ""
    f = 1
    for item in img:
        if f == 0:
            pet["img"] +="&"
        else:
            f = 0
        pet["img"] += item.img["src"]
    print(pet["full_name"])
    Insert(pet)
#crawl_other("https://www.ixiupet.com/cwspz/2308/",123)


# In[87]:


def crawl_breed(url,cate,id):
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36"}
    r = get(url,headers=headers)
    ret = r.content.decode('gb18030','ignore')
    soup = BeautifulSoup(ret, 'lxml')
    lis_url = []
    lis_url.append(url)
    for page in soup.find("div",class_="page").find_all("a"):
        if page.string != "首页" and page.string != "1" and page.string != "下一页" and page.string !="末页":
            lis_url.append(url+page["href"])
    dic = []
    for url in lis_url:
        r = get(url,headers=headers)
        ret = r.content.decode('gb18030','ignore')
        soup = BeautifulSoup(ret, 'lxml') 
        ul = soup.find_all("a",class_="tiyan-smll-li")
        for cont in ul:
            if id == 1 or id ==0:
                crawl_mg(cont["href"],cate)
            else:
                crawl_other(cont["href"],cate)
    
    print(cate)

db = pymysql.connect(host='127.0.0.1', port=3306, user='pineapple', password='123456', db='pethome', charset='utf8')
zoon=["狗","猫","兔子","虫宠","水族","宠物鼠","宠物貂","宠物鸟","两栖爬行","其他"]
db = pymysql.connect(host='127.0.0.1', port=3306, user='pineapple', password='123456', db='pethome', charset='utf8')
entry_url = "https://www.ixiupet.com/pinzhong/"
headers = {"User-Agent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36"}
r = get(entry_url,headers=headers)
ret = r.content.decode('gb18030','ignore')
soup = BeautifulSoup(ret, 'lxml')
lis_url = soup.find_all("li",class_="light-hover")
id = 0 
for item in lis_url:
    crawl_breed(item.a["href"],zoon[id],id)
    id +=1
    
# 关闭数据库连接
db.close()


# In[85]:



# 打开数据库连接

# 使用cursor()方法获取操作游标
db.close()

