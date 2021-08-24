#ifndef CMDPROC_H
#define CMDPROC_H

#include "Command.h"

class CommandProcessor
{
public:
    Command Process();
    Command GenerateCommand(vector<string> input);

};

#endif
