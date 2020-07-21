import re
import requests
import json
import sys
import urllib.parse
from bs4 import BeautifulSoup

확인만하시고 혹시나 실행은 하시면안돼요~~

try:
    title=sys.argv[1]
    address=sys.argv[2]
except:
    print("ERROR")
    sys.exit(1)

query = urllib.parse.quote(title+" "+address)
#query = title + " " + address

#url = 'https://m.map.naver.com/search2/search.nhn?query=' + query +'&sm=hty&style=v4'

url = 'https://m.map.naver.com/search2/search.nhn?query=' + query

html = requests.get(url).text
print(html)
print(url)

matched = re.search(r'var searchResult = (.*?);', html, re.S)

json_string = matched.group(1)

output_list = json.loads(json_string)

print(output_list)

id=output_list.get("site").get("list")[0].get("id")[1:]

time = ""
url2 = 'https://store.naver.com/restaurants/detail?id=' + id;
html = requests.get(url2).text
soup = BeautifulSoup(html, 'html.parser')

soup2 = soup.find("a", "biztime_area")

if(soup2) :
    for s in soup2.findAll("span", ["time", "desc"]):
        time += str(s)+"/"
else :
    soup2 = soup.find("div", "biztime_area")
    if(soup2):
        for s in soup2.findAll("span", ["time", "desc"]):
            time += str(s)+"/"

time = re.sub('<.+?>', '', time, 0).strip()

menu = ""
matched = re.search(r'window.PLACE_STATE=(.*?)</script>', html, re.S)
json_string = matched.group(1)
output_list = json.loads(json_string)

menus_image = output_list.get("business").get(id).get("base")

menus = menus_image.get("menus")
for m in menus:
    menu += m.get("name") + " - " + m.get("price") + "/"

image = ""

image += menus_image.get("images")[0].get("origin")
if(image):
    image = "https://search.pstatic.net/common/?autoRotate=true&quality=95&src=" + urllib.parse.quote(image) + "&type=f420_312"

result = {'id':id, 'time':time, 'menu':menu, 'image':image}
print (json.dumps(result))
