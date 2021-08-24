#ifndef FIELD_H
#define FIELD_H

#include "Common.h"

enum FieldState {
    FSEmpty,
    FSSelf,
    FSOpponent,
};

struct Field {

    int score;
    array<FieldState, 9> fieldSlots; 
    int lastMove;

    Field() {
        //Reset the field.
        for (int i = 0; i < 9; i++)
        {
            fieldSlots[i] = FieldState::FSEmpty;
        }

        score = 0;
    }

    Field(string data)
    {
        Set(data);
    }

    inline void SetSlot(int index, FieldState state)
    {
        if (index > 9 || index < 0)
        {
            cerr << "Trying to set slot of a field out of bounds: "
                << index 
                << endl;
            return;
        }

        fieldSlots[index] = state;
    }

    inline FieldState GetSlot(int index)
    {
        if (index > 9 || index < 0)
        {
            cerr << "Trying to set slot of a field out of bounds: "
                << index
                << endl;
            return FieldState::FSEmpty;
        }
        return fieldSlots[index];
    }

    void Set(string tape)
    {
        if (tape.size() < 9) {
            cerr << "Input tape must be 9 values!";
            return;
        }
      
        for (int i = 0; i < 9; i++)
        {
            char tapeValue = tape[i];

            switch (tapeValue)
            {
            case '.': SetSlot(i, FieldState::FSEmpty); break;
            case '0': SetSlot(i, FieldState::FSSelf); break;
            case '1': SetSlot(i, FieldState::FSOpponent); break;
            }
        }
    }

    inline bool IsTerminal()
    {
        for (int i = 0; i < 9; i++)
        {
            if (fieldSlots[i] == FieldState::FSEmpty)
                return false;
        }

        return true;
    }

    inline bool IsEmpty()
    {
        for (int i = 0; i < 9; i++)
        {
            if (fieldSlots[i] != FieldState::FSEmpty)
                return false;
        }

        return true;
    }

    inline vector<int> GetPlayableSlots()
    {
        vector<int> indices;

        for (int i = 0; i < 9; i++)
        {
            if (fieldSlots[i] == FSEmpty)
            {
                indices.push_back(i);
            }
        }

        return indices;
    }

    inline FieldState GetPlayerTurn()
    {
        int playerSelf = 0;
        int playerOpponent = 0;

        for (int i = 0; i < 9; i++)
        {
            if (fieldSlots[i] == FSSelf)
            {
                playerSelf++;
            }
            else if (fieldSlots[i] == FSOpponent)
            {
                playerOpponent++;
            }
        }

        if (playerSelf == playerOpponent) return FSSelf;
        return (playerSelf > playerOpponent) ? FSOpponent : FSSelf;
    }

    void SetLastMove(int move)
    {
        this->lastMove = move;
    }

    inline int GetLastMove()
    {
        return lastMove;
    }

};

#endif