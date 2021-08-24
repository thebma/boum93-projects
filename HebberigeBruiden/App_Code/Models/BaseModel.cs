using System;
using WebMatrix.Data;

public class BaseModel
{
    protected Exception LastError = null;

    public bool HasError
    {
        get
        {
            return LastError != null;
        }
    }

    protected Database RequestDB()
    {
        LastError = null;
        return Database.Open("HBDB");
    }

    public string GetErrorMessage()
    {
        return LastError.Message;
    }
}