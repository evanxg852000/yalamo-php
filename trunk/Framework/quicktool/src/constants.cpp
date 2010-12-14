#include "constants.h"
#include <iostream>

namespace Constants{

App *App::instance=0;

App::App(){
    this->actions[0]="exit";
    this->actions[1]="?";
    this->actions[2]="cls";
    this->actions[3]="prompt";
    this->actions[4]="path";
    this->actions[5]="list";
    this->actions[6]="project";
    this->actions[7]="module";
    this->actions[8]="extension";
    this->actions[9]="controller";
    this->actions[10]="model";
    this->actions[11]="view";
};

App::~App(){
    App::instance=0;
};

App* App::Instance(){
    if(App::instance==0){
        App::instance=new App();
    }
    return App::instance;
}

void App::Destroy(){
    if(App::instance){
        delete App::instance;
        cout<<App::instance;
    }
}

int App::Find(string val){
    int resultkey=-1;
    for(int i=0; i<nactions; i++){
        if(this->actions[i]==val){
            resultkey=i;
            break;
        }
    }
    return resultkey;
}




}
