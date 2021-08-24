#ifndef FIELD_MANAGER_H
#define FIELD_MANAGER_H

#include "Common.h"
#include "Command.h"
#include "Solver.h"
#include "Macrofield.h"

class FieldManager
{
public:
    FieldManager(Macrofield*);

    void Apply(Command command);
    Macrofield* GetMacro();

private:
    Macrofield* macrofield;
    void UpdateFields(string values);
};

#endif
