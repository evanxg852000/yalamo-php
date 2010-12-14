#include "application.h"
#include "constants.h"
#include "actions.h"


Application::Application(){
    this->prompt="yq:/ " ;
    this->exit=false;
    char currentpath[FILENAME_MAX];
    getcwd(currentpath, sizeof(currentpath)) ;
    this->path=(string)currentpath ;
}

void Application::Run(string commad, string arg){
    //ctor
}

void Application::Interract(){
    cout<<"\t\t -------------------------------------------"<<endl;
    cout<<"\t\t     Welcome to Yalamo Quick "<<endl;
    cout<<"\t\t     The quick tool for yalamo framework"<<endl;
    cout<<"\t\t     Yalamo version: 1.0"<<endl;
    cout<<"\t\t -------------------------------------------"<<endl<<endl;

    //start interaction loop
    while(!this->exit){
        this->Promt();
    }

}

void Application::Promt(){
    string command, input,substr;
    Array args;
    cout<<this->prompt;
    getline(cin,input);
    istringstream iss(input);
    iss>>command;
    do {
        iss >> substr;
        args.push_back(substr);
    } while(iss);
    args.pop_back();//remove the empty last one
    this->RunCommande(command,args);
}

void Application::RunCommande(string command,Array args){
  switch(Constants::App::Instance()->Find(command)){
    case 0: //exit
        this->exit=true;
        break;
    case 1: //?
        Actions::Help();
        this->Promt();
        break;
    case 2: //cls
        Actions::ClearScreen();
        this->Promt();
        break;
    case 3: //prompt
        Actions::SetPrompt(this,args);
        break;
    case 4: //path
        Actions::SetPath(this,args);
        break;
    case 5: //list
            Actions::ListDir(this,args);
            this->Promt();
        break;
    case 6: //project
        Actions::Project(this,args);
        this->Promt();
        break;
    case 7: //module
        Actions::Module(this,args);
        this->Promt();
        break;
    case 8: //extension
        Actions::Extension(this,args);
        this->Promt();
        break;
    case 9: //controller
        Actions::Controller(this,args);
        this->Promt();
        break;
    case 10: //model
        Actions::Model(this,args);
        this->Promt();
        break;
    case 11: //view
        Actions::View(this,args);
        this->Promt();
        break;
    default:
        cout<<"Command not found !"<<endl;
        this->Promt();
  }

}


Application::~Application(){
    Constants::App::Destroy();
}
