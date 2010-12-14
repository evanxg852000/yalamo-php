#ifndef ARRAY_H
#define ARRAY_H
#include <vector>
#include <string>
using namespace std;
class Array : public vector<string> {
    public:
    string getvalueof(unsigned int offset){
        if(this->size()>offset){
            return this->at(offset);
        }
        return " ";
    }

};

#endif // ARRAY_H
