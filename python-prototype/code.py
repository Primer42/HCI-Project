'''
Created on Mar 27, 2013

@author: will
'''
import web
from web import form
from web.template import render

render = web.template.render('templates/')

urls = (
        '/', 'index',
        '/add', 'add'
        )

addObjectForm = web.form.Form(
                              form.Textbox('name'),
                              form.Dropdown('type', [('person', 'Person'),('note','Note'),('job', 'Job')])
                              )

class add():
    def GET(self):
        form = addObjectForm()
        return render.formtest(form)
    def POST(self):
        form = addObjectForm()
        return "Great success! Added %s of type %s" % (form['name'], form['type'])


class index():
    def GET(self):
        return "Hello World"



if __name__ == '__main__':
    app = web.application(urls, globals())
    app.run()