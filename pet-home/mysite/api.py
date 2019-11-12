from django.http import  HttpResponse,JsonResponse
from  Wiki.models import   Wiki
from django.core import  serializers
import json

def qryWiki(req):
    rep = {}
    rep["data"] = ""
    if req.method == 'POST':
        q = json.loads(req.body.decode('utf-8'))
        if "full_name" in q.keys():
            rep["code"] = 1
            obj = Wiki.objects.get(full_name = q["full_name"])
            data = dict([(kk, obj.__dict__[kk]) for kk in obj.__dict__.keys() if kk != "_state"])
            rep["data"] = data
        else:
            rep["code"] = 2
    else:
        rep["code"] =  0
    return JsonResponse(rep, safe=False)

def qryCategory(req):
    rep = {}
    rep["data"] = []
    if req.method == 'POST':
        q = json.loads(req.body.decode('utf-8'))
        if "category" in q.keys():
            rep ["code"] = 1
            obj = Wiki.objects.filter(category = q["category"])
            for item in obj :
                tmp = {}
                tmp["full_name"] = item.full_name
                img = item.img.split('&')
                tmp["img"] = ""
                if len(img):
                    tmp["img"] = img[0]
                rep["data"].append(tmp)
        else:
            rep["code"] = 2
    else:
        rep["code"] =  0
    return JsonResponse(rep, safe=False)



