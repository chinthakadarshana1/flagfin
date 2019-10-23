namespace Flagfin.CoreAPI.Models
{
    public class Employee : BaseModel
    {
        public ApplicationUser User { get; set; }
        public string JobTitle { get; set; }
    }
}
