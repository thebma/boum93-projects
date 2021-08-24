public class BaseController
{
    private object debugObject = null;
    protected bool InDebug
    {
        get
        {
            return debugObject != null;
        }
    }

    public void SetDebug(object obj)
    {
        debugObject = obj;
    }

}