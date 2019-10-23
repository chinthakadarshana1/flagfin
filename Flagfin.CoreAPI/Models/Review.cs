using Flagfin.CoreAPI.Models.Enum;

namespace Flagfin.CoreAPI.Models
{
    public class Review : BaseModel
    {
        public Employee Reviewer { get; set; }
        public Employee Employee { get; set; }
        public ReviewStatus Status { get; set; }
        public string Comment { get; set; }
        public string Name { get; set; }
    }
}
