#include <stdlib.h>
#include <iostream>
#include "application.h"

using namespace std;

int main(int argc, char *argv[]){
    system("Color 02");
    if(argc==2){
         cout << "Error: yalQuick Needs at least 2 arguments!"  << endl;
    }
    Application *app=new Application();
    if(argc==3){
        app->Run(argv[1],argv[2]);
    }
    else{
        app->Interract();
    }
    delete app;
    return 0;
}
