using System.Web.Helpers;

public class Encryptor
{
    public static void GeneratePassword(string password, out string encrypted, out string salt)
    {
        salt = Crypto.GenerateSalt(16);
        encrypted = Crypto.Hash(password + salt, "SHA256");
    }

    public static bool CheckPassword(string inputPassword, string databasePassword, string salt)
    {
        string completePassword = inputPassword + salt;
        string encryptedPassword = Crypto.Hash(completePassword, "SHA256");

        return encryptedPassword == databasePassword;
    }
}