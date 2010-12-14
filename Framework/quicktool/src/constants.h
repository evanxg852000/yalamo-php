#ifndef CONSTANTS_H
#define CONSTANTS_H
#include <string>

namespace Constants{
    using namespace std;

    int const nactions=12;
    string const dirmodule="/yalamo/system/modules/";
    string const dirextension="/yalamo/extensions/";
    string const dircontroller="/yalamo/mvc/controllers/";
    string const dirmodel="/yalamo/mvc/models/";
    string const dirview="/yalamo/mvc/views/";

class App{
    public:
        static App* Instance();
        static void Destroy();
        int Find(string val);
        ~App();

    private:
        App();
        static App *instance;
        string actions[nactions];
};


}
#endif // CONSTANTS_H

