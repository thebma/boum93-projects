#include "Settings.h"

void Notify(string action, string value)
{
    cerr << "Command received for action: "
        << action
        << " with value(s): "
        << value
        << endl;
}

void Settings::Apply(Command command)
{
    if (command.key == "player_names")
    {
        Notify("set_player_names", command.value);
        bots = split_with_delim(command.value, ',');
    }
    else if (command.key == "your_bot")
    {
        Notify("set_your_bot", command.value);
        self_bot_name = command.value;
    }
    else if (command.key == "your_botid")
    {
        Notify("set_your_bot_id", command.value);
        self_bot_id = stoi(command.value);
    }
    else if (command.key == "timebank")
    {
        Notify("set_timebank", command.value);
        timebank = stoi(command.value);
    }
    else if (command.key == "time_per_move")
    {
        Notify("set_time_per_move", command.value);
        time_per_move = stoi(command.value);
    }
    else
    {
        Notify("invalid_settings_command", "");
    }
}