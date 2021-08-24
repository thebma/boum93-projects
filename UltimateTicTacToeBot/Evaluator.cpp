#include "Evaluator.h"
/*
    Evaluating row, columns and diagonals.:
        0 0 0 -> Empty, we don't care.
        0 0 o -> Opponent has ownership, two steps away
        0 o o -> Opponent has ownership, one step away.
        0 0 x -> Player has ownership, two steps away
        0 x x -> Player has ownership, one step away.
        0 x o -> Mixed row, this is a draw.
        x o x -> Mixed row, this is a draw.
        o o x -> Etc.
*/
const int EVAL_WIN = 5;
const int EVAL_MAX_NON_WIN = 3;
const int EVAL_ONE_STEP_AWAY = 2;
const int EVAL_TWO_STEP_AWAY = 1;

struct EvalResult
{
public:
    int score;
    FieldState owner;
    bool winner;

    EvalResult()
    {
        score = 0;
        owner = FSEmpty;
        winner = false;
    }

    EvalResult(int score, FieldState owner, bool winner)
    {
        this->score = score;
        this->owner = owner;
        this->winner = winner;
    }
};

//TODO: Implement some functions that determines the consecutiveness of an
//      array based on value, so we don't have to run same logic over and over again.
//
inline EvalResult EvaluateField(
    Field* field, FieldState perspective, array<int, 3> indices)
{
    int completed = 0;
    FieldState owner = FSEmpty;

    for (int i = 0; i < 3; i++)
    {
        FieldState currentOwner = field->GetSlot(indices[i]);

        if(currentOwner == FSEmpty)
            continue;

        if (owner == FSEmpty)
        {
            owner = currentOwner;
            completed++;
        }
        else
        {
            //This is a mixed set, no way we could possible
            //  Receive any points from this.
            if (owner != currentOwner)
            {
                return EvalResult(0, FSEmpty, false);
            }

            completed++;
        }
    }

    int score = 0;

    if (owner != FSEmpty)
    {
        if (completed == 1) score += EVAL_TWO_STEP_AWAY;
        if (completed == 2) score += EVAL_TWO_STEP_AWAY;
        if (completed == 3) score += EVAL_WIN;
    }

    bool hasWinner = completed == 3 && owner != FSEmpty;
    return EvalResult(score, owner, hasWinner);
}

int HasWinner(Field* field)
{
    vector<EvalResult> results = {
        //Rows...
        EvaluateField(field, FSSelf, { 0, 1, 2 }),
        EvaluateField(field, FSSelf, { 3, 4, 5 }),
        EvaluateField(field, FSSelf, { 6, 7, 8 }),

        //Cols...
        EvaluateField(field, FSSelf, { 0, 3, 6 }),
        EvaluateField(field, FSSelf, { 1, 4, 7 }),
        EvaluateField(field, FSSelf, { 2, 5, 8 }),

        //Diagonals...
        EvaluateField(field, FSSelf, { 0, 4, 8 }),
        EvaluateField(field, FSSelf, { 2, 4, 6 }),
    };

    vector<EvalResult>::const_iterator it = results.begin();

    for (; it != results.end(); it++)
    {
        EvalResult result = *it;

        if (result.winner)
        {
            return true;
        }
    }

    return false;
}

FieldState GetWinner(Field* field)
{
    vector<EvalResult> results = {
        //Rows...
        EvaluateField(field, FSSelf, { 0, 1, 2 }),
        EvaluateField(field, FSSelf, { 3, 4, 5 }),
        EvaluateField(field, FSSelf, { 6, 7, 8 }),

        //Cols...
        EvaluateField(field, FSSelf, { 0, 3, 6 }),
        EvaluateField(field, FSSelf, { 1, 4, 7 }),
        EvaluateField(field, FSSelf, { 2, 5, 8 }),

        //Diagonals...
        EvaluateField(field, FSSelf, { 0, 4, 8 }),
        EvaluateField(field, FSSelf, { 2, 4, 6 }),
    };

    vector<EvalResult>::const_iterator it = results.begin();

    for (; it != results.end(); it++)
    {
        EvalResult result = *it;

        if (result.winner)
        {
            return result.owner;
        }
    }

    return FSEmpty;
}


inline int Evaluate(Field* field, FieldState& perspective)
{
    int score = 0;

    vector<EvalResult> results = {
        //Rows...
        EvaluateField(field, perspective, { 0, 1, 2 }),
        EvaluateField(field, perspective, { 3, 4, 5 }),
        EvaluateField(field, perspective, { 6, 7, 8 }),
        
        //Cols...
        EvaluateField(field, perspective, { 0, 3, 6 }),
        EvaluateField(field, perspective, { 1, 4, 7 }),
        EvaluateField(field, perspective, { 2, 5, 8 }),

        //Diagonals...
        EvaluateField(field, perspective, { 0, 4, 8 }),
        EvaluateField(field, perspective, { 2, 4, 6 }),
    };

    vector<EvalResult>::const_iterator it = results.begin();

    for (; it != results.end(); it++)
    {
        EvalResult result = *it;

        if (result.winner)
        {
            if (result.owner == FSOpponent)
            {
                return -result.score;
            }
            else
            {
                return result.score;
            }
        }

        score += result.score;
    }

    //Clamp the values so it never exceeds the winning fields.
    if (score > EVAL_MAX_NON_WIN) return EVAL_MAX_NON_WIN;
    if (score < -EVAL_MAX_NON_WIN) return -EVAL_MAX_NON_WIN;
    return score;
}

//NOTE: Perspective means how this code is going to distinguish between player or enemy.
//      Based on the field states.
int FieldEvaluationFunction(Field* field, FieldState perspective)
{
    //Is the field empty?
    if (field->IsEmpty())
        return 0;

    return Evaluate(field, perspective);
}