using Flagfin.CoreAPI.Models.Enum;

namespace Flagfin.CoreAPI.DTO
{
    public class ReviewDTO
    {
        public int ReviewId { get; set; }
        public int ReviewerId { get; set; }
        public string ReviewerName { get; set; }
        public int EmployeeId { get; set; }
        public string EmployeeName { get; set; }
        public string Status { get; set; }
        public int StatusId { get; set; }
        public string Comment { get; set; }
        public string Name { get; set; }
    }
}
