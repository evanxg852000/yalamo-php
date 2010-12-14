#ifndef APPLICATION_H
#define APPLICATION_H
#include <stdlib.h>
#include <direct.h>
#include <iostream>
#include <sstream>
#include <string>
#include <vector>
#include "array.h"



using namespace std;

class Application{
    public:
        Application();
        ~Application();
        void Run(string command, string arg );
        void Interract();
        void SetPrompt(string val) { prompt = val+":/ "; }
        void SetPath(string val) { path = val; }
        string GetPath(){return path;}

    protected:

    private:
        string prompt;
        string path;
        bool exit;
        void Promt();
        void RunCommande(string command,Array args);

};

#endif // APPLICATION_H
