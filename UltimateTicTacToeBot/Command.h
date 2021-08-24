#ifndef COMMAND_HDR
#define COMMAND_HDR

#include "Common.h"

enum CommandScope {
    CmdScopeInvalid,
    CmdScopeSettings,
    CmdScopeUpdate,
    CmdScopeAction
};

inline const char* CommandScopeStr(CommandScope scope)
{
    switch (scope) {
        case CmdScopeInvalid: return "Invalid";
        case CmdScopeSettings: return "Settings";
        case CmdScopeUpdate: return "Update";
        case CmdScopeAction: return "Action";
        default: return "????";
    }
}

struct Command {
    CommandScope scope;
    string key;
    string value;
    string player;

    Command() 
    {
        this->scope = CommandScope::CmdScopeInvalid;
    }

    Command(CommandScope scope, string key, string value)
    {
        this->scope = scope;
        this->key = key;
        this->value = value;
    }

    Command(CommandScope scope, string key, string value, string player) 
    {
        this->scope = scope;
        this->key = key;
        this->value = value;
        this->player = player;
    }
};

inline ostream& operator << (ostream& os, const Command& cmd)  
{
    os  << CommandScopeStr(cmd.scope)
        << ", "
        << cmd.key
        << ", "
        << cmd.value
        << ", "
        << cmd.player
        << endl;

    return os;
}

#endif