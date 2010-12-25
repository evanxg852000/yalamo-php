#ifndef ACTIONS_H
#define ACTIONS_H
#include <fstream>
#include <cctype>
#include <cstring>
#include <dirent.h>



namespace Actions {

using namespace std;

bool checkarglength(Array args,unsigned int n){
    if(args.size()<n){
        return false;
    }
    return true;
}
void paramerror(){
    cout<<"Command expects more parameters! "<<endl;
}
bool createfile(string &fullpath,string const &content){
    ofstream stream(fullpath.c_str());
	if(stream){
        stream<<content<<endl;
        stream.close();
        return true;
	}
	return false;
}
string capitalise(string text){
    const char *car=text.c_str();
    char cpy[strlen(car)];
    cpy[0]=std::toupper(car[0]);
    for(unsigned int i=1;i<strlen(car)-1;i++){
        cpy[i]=car[i];
    }
    return (string) cpy ;
}

void Help(){
    cout.fill(' ');
    cout<<"---------- Yalamo Quick Help ----------"<<endl;
    cout<<" exit:       Exit yalQuick"<<endl;
    cout<<" ?:          Show help content"<<endl;
    cout<<" cls:        Clear the screen"<<endl;
    cout<<" prompt:     Set the command line prompt"<<endl;
    cout<<" path:       Set the working directory"<<endl;
    cout<<" list:       List the comtent of the curent directory "<<endl;
    cout<<" project:    Create yalamo project in the current directory "<<endl;
    cout<<" module:     Create module in the curent project"<<endl;
    cout<<" extension:  Create extension in the current project"<<endl;
    cout<<" controller: Create controller in the current project"<<endl;
    cout<<" model:      Create model in the current project"<<endl;
    cout<<" view:       Create view in the current project"<<endl;
}

void ClearScreen(){
    system("cls");
}

void SetPrompt(Application *app,Array &args){
    if(checkarglength(args,1)){
        string argval=args.getvalueof(0);
        if(argval !=""){
            app->SetPrompt(argval);
        }
        return ;
    }
    paramerror();
}

void SetPath(Application *app, Array &args){
    if(checkarglength(args,1)){
        string argval=args.getvalueof(0);
        if(argval !=""){
            app->SetPath(argval);
        }
        return ;
    }
    else{
        cout<<app->GetPath()<<endl;
    }
}

void ListDir (Application *app, Array &args){
    DIR *pdir = NULL;
    pdir = opendir (app->GetPath().c_str());
    struct dirent *pent = NULL;
    if (pdir == NULL){ return;}
    while ((pent = readdir (pdir))){
        if (pent == NULL){
            return;
        }
       cout<<pent->d_name<<endl;
    }
    closedir (pdir);
}

void Project(Application *app, Array &args){
    if(checkarglength(args,1)){
        string projectname=args.getvalueof(0);
        if(projectname !=""){
            cout<<"No Supported yet"<<endl;
        }
        return ;
    }
    paramerror();
}

void Module (Application *app, Array &args){
   if(checkarglength(args,1)){
        string modulename=capitalise(args.getvalueof(0));
        if(modulename !=""){
            string path=app->GetPath()+Constants::dirmodule+modulename+".php";
            string content="<?php\nclass "+modulename+" extends Object {\n\tpublic function __construct(){\n\n\t}\n}";
            if(!createfile(path,content)){
                cout<<"Not able to create the module !"<<endl;
            }
        }
        return ;
    }
    paramerror();
}

void Extension (Application *app, Array &args){
    if(checkarglength(args,1)){
        string extname=capitalise(args.getvalueof(0));
        if(extname !=""){
            string path=app->GetPath()+Constants::dirextension+extname+".php";
            string content="<?php\nclass "+extname+" extends Object {\n\tpublic function __construct(){\n\n\t}\n}";
            if(!createfile(path,content)){
                cout<<"Not able to create the extension !"<<endl;
            }
        }
        return ;
    }
    paramerror();
}

void Controller(Application *app, Array &args){
    if(checkarglength(args,1)){
        string ctrlname=capitalise(args.getvalueof(0));
        if(ctrlname !=""){
            string path=app->GetPath()+Constants::dircontroller+ctrlname+".php";
            string content="<?php\nclass "+ctrlname+" extends Controller {\n\tpublic function  Index() {\n\t\t$this->Show('view');\n\t}\n}";
            if(!createfile(path,content)){
                cout<<"Not able to create the controller !"<<endl;
            }
        }
        return ;
    }
    paramerror();
}

void Model (Application *app, Array &args){
    if(checkarglength(args,1)){
        string modelname=capitalise(args.getvalueof(0));
        if(modelname !=""){
            string path=app->GetPath()+Constants::dirmodel+modelname+".php";
            string content="<?php\nclass "+modelname+" extends Model {\n\tpublic function  __construct() {\n\t\tparent::__construct();\n\t}\n}";
            if(!createfile(path,content)){
                cout<<"Not able to create the model !"<<endl;
            }
        }
        return ;
    }
    paramerror();
}

void View (Application *app, Array &args){
    if(checkarglength(args,1)){
        string viewname=capitalise(args.getvalueof(0));
        if(viewname !=""){
            string path=app->GetPath()+Constants::dirview+viewname+".php";
            string content="<html>\n<head>\n\t<title>"+viewname+"</title>\n</head>\n<body>\n\n</body>\n</html>";
            if(!createfile(path,content)){
                cout<<"Not able to create the view !"<<endl;
            }
        }
        return ;
    }
    paramerror();
}


}
#endif // ACTIONS_H
