#ifndef SETTINGS_HDR
#define SETTINGS_HDR

#include "Common.h"
#include "Command.h"

class Settings
{
public:
    void Apply(Command command);

    //TODO: Implement the accessors we need.
private:
    vector<string> bots;
    string self_bot_name;
    int self_bot_id;
    string enemy_bot_name;

    int timebank;
    int time_per_move;
};

#endif

