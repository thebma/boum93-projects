#include "FieldManager.h"

FieldManager::FieldManager(Macrofield* mfield)
{
    this->macrofield = mfield;
}

void FieldManager::UpdateFields(string tape)
{
    vector<string> tapeValues = split_with_delim(tape, ',');
    string rowData = "";
    int fieldIndex = 0;

    //Loop over the 3 blocks (of 3 rows)
    for (int block = 0; block < 3; block++)
    {
        //Loop over the 3 columns.
        for (int col = 0; col < 3; col++)
        {
            //Loop over the row.
            for (int row = 0; row < 3; row++)
            {
                //Loop over the sub index.
                for (int sub = 0; sub < 3; sub++)
                {
                    int index = (block * 27) + (row * 9 + col * 3 + sub);
                    rowData += tapeValues[index];
                }
            }

            macrofield->SetField(fieldIndex++, rowData);
            rowData = "";
        }
    }
}

void FieldManager::Apply(Command command)
{
    //Commands that affect the entire game for both sides.
    if (command.player == "game")
    {
        if (command.key == "field")
        {
            //Update the definitions of the fields.
            this->UpdateFields(command.value);
            cerr << "Received field update";
        }
        else if (command.key == "macroboard")
        {
            Macrofield* mfield = this->GetMacro();
            mfield->GetMandatoryField(command.value);
            mfield->GetSignificantFields(command.value);
            cerr << "Received macro update";
        }
    }
}

Macrofield* FieldManager::GetMacro()
{
    return this->macrofield;
}
