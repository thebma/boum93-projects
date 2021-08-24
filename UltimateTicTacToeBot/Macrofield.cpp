#include "Macrofield.h"

Macrofield::Macrofield() 
{
    for (int i = 0; i < 9; i++)
    {
        Field* field_ptr = new Field();
        fields[i] = field_ptr;
    }
}

void Macrofield::SetField(int index, string fieldData)
{
    if (index < 0 || index > 9) return;

    Field* field = GetField(index);
    field->Set(fieldData);
}

Field* Macrofield::GetField(int index)
{
    return fields.at(index);
}

//Returns a weighted array of the fields contained in the macro board.
array<float, 9> Macrofield::GetNormalizedFieldScores()
{
    array<int, 9> fieldScores;
    array<float, 9> normalizedScores;

    //Get the baseline scores.
    int max = -1000;
    for (int i = 0; i < 9; i++)
    {
        int score = FieldEvaluationFunction(this->fields[i], FSSelf);
        
        if (score < 0)
            score = 0;

        if (score > max)
            max = score;

        fieldScores[i] = score;
    }

    
    for (int i = 0; i < 9; i++)
    {
        float fraction = 0.0f;
        
        //Don't divide by zero :(
        if (max > 0.0f && fieldScores.at(i) > 0.0f)
        {
            //Should return between 0.0 and 1.0.
            fraction = normalizedScores[i] / max;
        }
        else
        {
            fraction = 0.0f;
        }

        normalizedScores[i] = fraction;
    }

    return normalizedScores;
}

void Macrofield::GetMandatoryField(string input)
{
    //NOTE: -2 to indicate no value.
    //      -1 is reserved for an "any" move.
    int mandatoryField = -2;
    bool hasMandatoryField = false;

    vector<string> values = split_with_delim(input, ',');

    for (int i = 0; i < 9; i++)
    {
        if (values[i] == "-1")
        {
            if (!hasMandatoryField)
            {
                mandatoryField = i;
                hasMandatoryField = true;
            }
            else
            {
                mandatoryField = -1;
                break;
            }

        }
    }

    this->mandatoryField = mandatoryField;
}

void Macrofield::GetSignificantFields(string input)
{
    vector<string> values = split_with_delim(input, ',');
    array<bool, 9> res;

    for (int i = 0; i < 9; i++)
    {
        string c = values.at(i);

        //If either the playing field or undecided field.
        if (c == "-1" || c == ".")
        {
            Field* field = GetField(i);

            if (field->IsTerminal())
            {
                res[i] = false;
            }
            else
            {
                res[i] = true;
            }
        }
        else
        {
            res[i] = false;
        }
    }

    cerr << "I've set the sigfields!" << endl;
    this->significantFields = res;
}
