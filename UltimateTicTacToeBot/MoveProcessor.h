#ifndef MOV_PROC_H
#define MOV_PROC_H

#include "Common.h"
#include "FieldManager.h"
#include "Settings.h"

class MoveProcessor
{
public:
    MoveProcessor(Settings&, FieldManager&);
    string ProcessMove();

private:
    Settings& gameSettings;
    Solver solver;
    FieldManager& gameField;


    Vector2 DoAnyFieldMove();
    Vector2 DoSpecificFieldMove(int index, Field* field);

    int GetMoveForField(Field field);
};

#endif