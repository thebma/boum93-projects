//TODO: this probably doesn't need to be included in common.h
//      Since most code files use this and will automatically add
//      the translation unit to their code, thus more overhead.
#include <iostream>
#include <sstream>
#include <vector>
#include <iterator>
#include <array>
#include <random>
#include <functional>

using namespace std;

#ifndef COMMON_H
#define COMMON_H

struct Vector2 {
    int x;
    int y;

    Vector2() 
    { 
        x = 0; 
        y = 0; 
    }

    Vector2(int x, int y)
    {
        this->x = x;
        this->y = y;
    }
};

inline vector<string> split_with_delim(const string& s, char delimiter)
{
    vector<string> tokens;
    string token;
    istringstream tokenStream(s);

    while (getline(tokenStream, token, delimiter))
    {
        tokens.push_back(token);
    }

    return tokens;
}

inline Vector2 translate_coordinates(int fieldIndex, int fieldSubIndex)
{
    int x = (fieldIndex % 3) * 3 + (fieldSubIndex % 3);
    int y = (fieldIndex / 3) * 3 + (fieldSubIndex / 3);
    return Vector2(x, y);
}

#endif