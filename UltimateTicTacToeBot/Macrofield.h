#ifndef MACROFIELD_H
#define MACROFIELD_H

#include "Common.h"

#include "Field.h"
#include "Evaluator.h"

class Macrofield
{
public:

    Macrofield();

    void SetField(int index, string fieldData);
    Field* GetField(int index);

    void GetMandatoryField(string input);
    void GetSignificantFields(string input);
    array<float, 9> GetNormalizedFieldScores();

    array<Field*, 9> fields;
    array<bool, 9> significantFields;
    int mandatoryField = -432817481;
};

#endif