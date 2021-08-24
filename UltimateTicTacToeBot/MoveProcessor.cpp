#include "MoveProcessor.h"

MoveProcessor::MoveProcessor(Settings& settings, FieldManager& field)
    : gameSettings(settings), gameField(field), solver(Solver())
{}

int MoveProcessor::GetMoveForField(Field field)
{
    int move = -1;

    if (field.IsTerminal())
        return move;

    Field* field_ptr = &field;
    if (HasWinner(field_ptr))
        return move;

    return solver.ProcessMove(field);
}

string MoveProcessor::ProcessMove()
{
    Vector2 placement;
    Macrofield* mfield = gameField.GetMacro();

    if (mfield->mandatoryField < 0)
    {
        placement = this->DoAnyFieldMove();
    }
    else
    {
        Field* field = mfield->GetField(mfield->mandatoryField);
        placement = this->DoSpecificFieldMove(mfield->mandatoryField, field);
    }

    stringstream command;
    command << "place_disc ";
    command << placement.x << " ";
    command << placement.y;

    return command.str();
}

Vector2 MoveProcessor::DoAnyFieldMove()
{
    Macrofield* mfield = gameField.GetMacro();

    //Get all the field scores (is between 0.0 to 1.0 derived from the highest score).
    array<float, 9> normalizedFields = mfield->GetNormalizedFieldScores();

    //Find the best field that isn't insignificant.
    int bestFieldIndex = -1;
    float bestFieldScore = 0.0f;

    for (int i = 0; i < 9; i++)
    {
        //Filter out any fields that have no use anymore.
        if (!mfield->significantFields.at(i))
        {
            continue;
        }

        if (normalizedFields.at(i) > bestFieldScore)
        {
            bestFieldIndex = i;
            bestFieldScore = normalizedFields.at(i);
        }
    }

    //Uuuh we don't have any major focus point... 
    //  So pick one random?
    if (bestFieldIndex == -1)
    {
        mt19937 mersenne_twister;
        mersenne_twister.seed(random_device()());
        uniform_int_distribution<mt19937::result_type> rng(0, 8);

        bestFieldIndex = rng(mersenne_twister);
    }

    //Play out our move.

    //Get our field.
    Field* field = mfield->GetField(bestFieldIndex);

    //Find a move for this field.
    int move = this->GetMoveForField(*field);
    return translate_coordinates(bestFieldIndex, move);
}

Vector2 MoveProcessor::DoSpecificFieldMove(int index, Field* field)
{   
    //Find a move for this field.
    int move = this->GetMoveForField(*field);
    return translate_coordinates(index, move);
}

