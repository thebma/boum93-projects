#include "CommandProcessor.h"
#include "MoveProcessor.h"
#include "FieldManager.h"
#include "Settings.h"

#include "Solver.h"

void HandleSettingsCommand(Settings&, Command);
void HandleUpdateCommand(FieldManager&, Command);
void HandleActionCommand(MoveProcessor&, Command);
void HandleInvalidCommand(Command);
void HandleAnyCommand(Command);
void HandleUnknownCommand(Command);

int main() 
{
    //Reference to our classes.
    Settings settings = Settings();

    Macrofield field = Macrofield();
    Macrofield* field_ptr = &field;
    FieldManager fieldManager = FieldManager(field_ptr);

    MoveProcessor moveProc = MoveProcessor(settings, fieldManager);
    CommandProcessor cmdproc = CommandProcessor();

    while (true)
    {
        Command cmd = cmdproc.Process();

        //The command is anything but invalid... then log it.
        if (cmd.scope != CommandScope::CmdScopeInvalid)
            //HandleAnyCommand(cmd);

        switch (cmd.scope)
        {
        case CmdScopeInvalid:  HandleInvalidCommand(cmd); break;
        case CmdScopeAction:   HandleActionCommand(moveProc, cmd); break;
        case CmdScopeSettings: HandleSettingsCommand(settings, cmd); break;
        case CmdScopeUpdate:   HandleUpdateCommand(fieldManager, cmd); break;
        default:               HandleUnknownCommand(cmd);
        }
    }
	return 0;
}

void HandleInvalidCommand(Command cmd) 
{
    cerr << "HandleInvalidCommnad: Received -> " << cmd;
}

void HandleUnknownCommand(Command cmd)
{
    cerr << "HandleUnknownCommand: Received command is unknown -> " << cmd;
}

void HandleAnyCommand(Command cmd)
{
    cerr << "HandleAnyCommand: Received -> " << cmd;
}

void HandleActionCommand(MoveProcessor& moveProc, Command cmd)
{
    string move = moveProc.ProcessMove();
    cerr << "Making a move!... " << move << endl;
    cout << move << endl;
}

void HandleSettingsCommand(Settings& settings, Command cmd)
{
    settings.Apply(cmd);
}

void HandleUpdateCommand(FieldManager& fieldManager, Command cmd)
{
    fieldManager.Apply(cmd);
}