#include "CommandProcessor.h"

void InvalidCommand(vector<string> input, string message)
{
    cerr << "Invalid command, input: ";

    vector<string>::const_iterator it = input.begin();

    for (; it != input.end(); it++)
    {
        cerr << *it;
    }

    cerr << "... message: " << message << endl;
}

bool VerifyCommandSize(vector<string> input, int size)
{
    if (input.size() < size)
    {
        stringstream msgStream;
        msgStream << "Command must at least have ";
        msgStream << size;
        msgStream << " input variables.";

        InvalidCommand(
            input,
            msgStream.str()
        );

        return false;
    }

    return true;
}

Command CommandProcessor::Process()
{
    string tempLine;
    vector<string> commandInput;

    while (getline(cin, tempLine))
    {
        commandInput = split_with_delim(tempLine, ' ');
        return this->GenerateCommand(commandInput);
    }

    //Return invalid command (which is implicitly set in an empty constructor).
    return Command();
}

Command CommandProcessor::GenerateCommand(vector<string> input)
{
    if (!VerifyCommandSize(input, 1))
        return Command();

    //Parse the first part of the command.
    CommandScope type;
    string identifier = input[0].c_str();

    if (identifier == "settings")
    {
        type = CommandScope::CmdScopeSettings;

        if (!VerifyCommandSize(input, 3))
            return Command();

        return Command(
            CommandScope::CmdScopeSettings, 
            input[1], 
            input[2]
        );
    }
    else if (identifier == "update")
    {
        type = CommandScope::CmdScopeUpdate;

        if (!VerifyCommandSize(input, 4))
            return Command();

        return Command(
            CommandScope::CmdScopeUpdate,
            input[2],
            input[3],
            input[1]
        );
    }
    else if (identifier == "action")
    {
        if (!VerifyCommandSize(input, 3))
            return Command();

        return Command(
            CommandScope::CmdScopeAction,
            input[1],
            input[2]
        );
    }

    return Command();
}


