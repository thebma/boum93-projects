#include "Solver.h"

Solver::Solver() {}

int Solver::Heuristic(Field field, int depth)
{
    Field* fptr = &field;
    FieldState winner = GetWinner(fptr);
    int depthInv = 9 - depth;

    if (winner == FSSelf)
    {
        return 9 - depthInv;
    }
    else if(winner == FSOpponent)
    {
        return -9 + depthInv;
    }

    return 0;
}

void Solver::Reset()
{
    AiBestMove = -999;
    AiBestScore = -999;
}

int Solver::ProcessMove(Field field)
{
    Reset();

    AlphaBetaPruningSolver(field, 9,
        SOLVER_MAXIMIZER_WORST,
        SOLVER_MINIMIZER_WORST,
        true
    );

    return this->AiBestMove;
}

vector<Field> Solver::Expand(Field field)
{
    vector<Field> mutatedFields;
    FieldState currentPlayer = field.GetPlayerTurn();
    vector<int> valid_slots = field.GetPlayableSlots();

    //Generate all the valid moves.
    vector<int>::const_iterator it = valid_slots.begin();

    //Play one move on all the boards.
    for (int i = 0; i < valid_slots.size(); i++)
    {
        Field mutatedField = field;
        mutatedField.SetSlot(valid_slots[i], currentPlayer);
        mutatedField.SetLastMove(valid_slots[i]);
        mutatedFields.push_back(mutatedField);
    }

    return mutatedFields;
}

int Solver::MinimaxSolver(Field field, int depth, bool maximizing)
{
    if (depth == 0 || field.IsTerminal())
    {
        FieldState player = maximizing ? FSSelf : FSOpponent;
        return Heuristic(field, player);
    }

    if (maximizing)
    {
        //Assign the worst value the maximizer could ever get.
        int max_value = SOLVER_MAXIMIZER_WORST;

        //Expand the field, find the children by brute forcing all the moves.
        vector<Field> children = Expand(field);
        //cerr << children.size() << endl;
        vector<Field>::const_iterator it = children.begin();

        //Go down in a DFS manner for all the children.
        for (int i = 0; i < children.size(); i++)
        {
            int score = MinimaxSolver(*it, depth - 1, false);
            max_value = max(max_value, score);

            if (max_value > AiBestScore)
            {
                AiBestMove = field.GetLastMove();
                AiBestScore = max_value;
            }
        }

        return max_value;
    }
    else
    {
        //Assign the worst value the maximizer could ever get.
        int min_value = SOLVER_MINIMIZER_WORST;

        //Expand the field, find the children by brute forcing all the moves.
        vector<Field> children = Expand(field);
        vector<Field>::const_iterator it = children.begin();

        //Go down in a DFS manner for all the children.
        for (int i = 0; i < children.size(); i++)
        {
            min_value = min(min_value, MinimaxSolver(*it, depth - 1, true));
            //NOTE: we don't care what the player move are.
        }

        return min_value;
    }
}

int Solver::AlphaBetaPruningSolver(
    Field field, int depth, int alpha, int beta, bool maximizing)
{
    FieldState player = maximizing ? FSSelf : FSOpponent;
    if (depth == 0 || field.IsTerminal())
    {
        return this->Heuristic(field, depth);
    }

    if (maximizing)
    {
        //Assign the worst value the maximizer could ever get.
        int max_value = SOLVER_MAXIMIZER_WORST;

        //Expand the field, find the children by brute forcing all the moves.
        vector<Field> children = Expand(field);
        //cerr << children.size() << endl;
        vector<Field>::const_iterator it = children.begin();

        //Go down in a DFS manner for all the children.
        for (int i = 0; i < children.size(); i++)
        {
            int score = AlphaBetaPruningSolver(*it, depth - 1, alpha, beta, false);

            max_value = max(
                max_value,
                score
            );

            alpha = max(alpha, max_value);

            if (max_value > AiBestScore)
            {
                AiBestMove = children[i].GetLastMove();
                AiBestScore = max_value;
            }

            if (alpha >= beta)
            {
                break;
            }
        }

        return max_value;
    }
    else
    {
        //Assign the worst value the maximizer could ever get.
        int min_value = SOLVER_MINIMIZER_WORST;

        //Expand the field, find the children by brute forcing all the moves.
        vector<Field> children = Expand(field);
        vector<Field>::const_iterator it = children.begin();

        //Go down in a DFS manner for all the children.
        for (int i = 0; i < children.size(); i++)
        {
            min_value = min(
                min_value,
                AlphaBetaPruningSolver(*it, depth - 1, alpha, beta, true)
            );

            beta = min(beta, min_value);

            if (alpha > beta)
            {
                break;
            }
        }

        return min_value;
    }
}
