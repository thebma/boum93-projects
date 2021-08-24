using System.Collections.Generic;
using System.Web;

public class LoginController : BaseController
{
    private UserModel userModel = new UserModel();

    public List<string> LoginUser(string name, string password)
    {
        List<string> errors = new List<string>();

        User user = new User()
        {
            Name = name,
            Password = password
        };

        bool result = userModel.CheckUserCredentials(user);

        if(result)
        {
            HttpContext ctx = HttpContext.Current;
            ctx.Session["hb_login_name"] = name;
            
            ctx.Response.Redirect("Success.cshtml?action=login");
            return errors;
        }
        else
        {
            errors.Add("The given username or password was incorrect");
            return errors;
        }
    }
}