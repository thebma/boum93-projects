using System.Collections.Generic;
using System.Web;

public class RegisterController : BaseController
{
    private UserModel userModel = new UserModel();

    public List<string> RegisterUser(string name, string password)
    {
        List<string> errors = new List<string>();

        User user = new User()
        {
            Name = name,
            Password = password
        };

        RegisterState state = userModel.AddUser(user);

        switch (state)
        {
            case RegisterState.OK:
                HttpContext.Current.Response.Redirect("Success.cshtml?action=register");
                break;
            case RegisterState.Unknown:

                if (userModel.HasError && InDebug)
                {
                    HttpContext.Current.Response.Write(userModel.GetErrorMessage());
                }
                else
                {
                    HttpContext.Current.Response.Redirect("Error.cshtml?error=500");
                }
                break;
            case RegisterState.UserExists:
                errors.Add("An user with this name already exists.");
                break;
        }

        return errors; 
    }
}