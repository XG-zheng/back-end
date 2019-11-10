
# coding: utf-8

# In[1]:


from requests import get
from filetype import guess
from os import rename
from os import makedirs
from os.path import exists
from json import loads
from contextlib import closing
import gzip
from bs4 import BeautifulSoup

def getText(node):
    s = ""
    for item in node.find_all("p"):
        s += item.text
    return s

def crawl(url):
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36"}
    r = get(url,headers=headers)
    ret = r.content.decode('gb18030','ignore')
    soup = BeautifulSoup(ret, 'lxml')
    info = soup.find_all('div',class_="word")
    pet = {}
    info1 = soup.find("ul",class_="c1text3")
    lis = info1.find_all("li")
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
    return pet
if __name__ == '__main__':
    url = "https://www.ixiupet.com/mmpz/891/"
    print(crawl(url))
    


# In[ ]:


def crawl_breed(url):
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
            dic.append(crawl(cont["href"]))
    
    print(url,len(dic))
    return dic
entry_url = "https://www.ixiupet.com/pinzhong/"
headers = {"User-Agent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36"}
r = get(entry_url,headers=headers)
ret = r.content.decode('gb18030','ignore')
soup = BeautifulSoup(ret, 'lxml')
lis_url = soup.find_all("li",class_="light-hover")
for item in lis_url:
    crawl_breed(item.a["href"])

