public enum NavLinkAlignment
{
    Left,
    Right
}

public enum NavLinkShow
{
    Always,
    LoggedIn,
    LoggedOut
}

public class NavLink
{
    public string Name;
    public string Href;
    public string Icon;
    public NavLinkAlignment Alignnment;
    public NavLinkShow ShowState;

    public NavLink(string name, string href, string icon, NavLinkAlignment alignment, NavLinkShow showState)
    {
        Name = name;
        Href = href;
        Icon = icon;
        Alignnment = alignment;
        ShowState = showState;
    }

    public bool ShouldShow(bool loggedIn)
    {
        if (ShowState == NavLinkShow.Always) return true;

        if(loggedIn)
        {
            return ShowState == NavLinkShow.LoggedIn;
        }
        else
        {
            return ShowState == NavLinkShow.LoggedOut;
        }
    }
}