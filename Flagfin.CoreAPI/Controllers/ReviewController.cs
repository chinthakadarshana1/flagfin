using AutoMapper;
using Flagfin.CoreAPI.DB;
using Flagfin.CoreAPI.DTO;
using Flagfin.CoreAPI.Filters;
using Flagfin.CoreAPI.Models;
using Flagfin.CoreAPI.Models.Enum;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;

namespace Flagfin.CoreAPI.Controllers
{
    [Route("api/[controller]/[action]")]
    [ApiController]
    public class ReviewController : ControllerBase
    {

        private readonly ApplicationDbContext _dbContext;
        private readonly IMapper _mapper;

        public ReviewController(
            ApplicationDbContext dbContext,
            IMapper mapper
        )
        {
            _dbContext = dbContext;
            _mapper = mapper;
        }

        [CustomAuthorization(UserTypes.BasicUser)]
        [HttpPost]
        public async Task<IActionResult> Get(ReviewDTO request)
        {
            var review = await _dbContext.Reviews
                .Include(x => x.Reviewer.User)
                .Include(x => x.Employee.User)
                .FirstOrDefaultAsync(e => e.Id == request.ReviewerId);

            ReviewDTO ret = _mapper.Map<ReviewDTO>(review);
            return Ok(ret);
        }

        [CustomAuthorization(UserTypes.BasicUser)]
        [HttpPost]
        public async Task<IActionResult> Add([FromBody] ReviewDTO request)
        {
            if (ModelState.IsValid)
            {
                Review review = new Review();

                var reviewer = await _dbContext.Employees.FirstOrDefaultAsync(e => e.Id == request.ReviewerId);
                var employee = await _dbContext.Employees.FirstOrDefaultAsync(e => e.Id == request.EmployeeId);

                review.Reviewer = reviewer;
                review.Employee = employee;
                review.Status = ReviewStatus.Pending;
                review.Comment = request.Comment;
                review.Name = request.Name;

                _dbContext.Reviews.Add(review);
                await _dbContext.SaveChangesAsync();

                ReviewDTO ret = _mapper.Map<ReviewDTO>(review);
                return Ok(ret);
            }
            else
                return BadRequest(ModelState);
        }

        [CustomAuthorization(UserTypes.BasicUser)]
        [HttpPost]
        public async Task<IActionResult> Update([FromBody] ReviewDTO request)
        {
            if (ModelState.IsValid)
            {
                var review = await _dbContext.Reviews
                   .FirstOrDefaultAsync(e => e.Id == request.ReviewerId);

                if (review != null)
                {
                    //update employee
                    review.Reviewer = new Employee() { Id = request.ReviewerId };
                    review.Employee = new Employee() { Id = request.EmployeeId };
                    review.Status = ReviewStatus.Pending;
                    review.Comment = request.Comment;
                    review.Name = request.Name;

                    await _dbContext.SaveChangesAsync();

                    ReviewDTO ret = _mapper.Map<ReviewDTO>(review);
                    return Ok(ret);
                }
                return BadRequest("Invalid Review");
            }
            else
                return BadRequest(ModelState);
        }


        [CustomAuthorization(UserTypes.BasicUser)]
        [HttpPost]
        public async Task<IActionResult> Search(SearchQueryDTO<ReviewDTO> request)
        {
            //excluding admin user
            IQueryable<Review> query = _dbContext.Reviews;

            //creating dynamic search query
            if (!string.IsNullOrEmpty(request.FreeText))
            {
                query = query
                    .Where(en => EF.Functions.Like(en.Reviewer.User.UserName, $"%{request.FreeText}%") ||
                                    EF.Functions.Like(en.Employee.User.UserName, $"%{request.FreeText}%") ||
                                    EF.Functions.Like(en.Name, $"%{request.FreeText}%") ||
                                    en.Id== request.SearchModel.ReviewerId);
            }
            else
            {
                query = query
                    .Where(en => (request.SearchModel.ReviewerId == 0 || en.Reviewer.Id == request.SearchModel.ReviewerId) &&
                                 (request.SearchModel.EmployeeId == 0 || en.Employee.Id == request.SearchModel.EmployeeId) &&
                                 (request.SearchModel.StatusId == 0 || en.Status == (ReviewStatus)request.SearchModel.StatusId) &&
                                 (string.IsNullOrEmpty(request.SearchModel.Name) || EF.Functions.Like(en.Name, $"%{request.SearchModel.Name}%")) &&
                                 (request.SearchModel.ReviewId == 0 || en.Id == request.SearchModel.ReviewId));
            }

            // Execute the query
            var totalCount = await query.CountAsync();
            var reviews = await query
                .Include(x => x.Reviewer.User)
                .Include(x => x.Employee.User)
                .Skip(request.PageSize * (request.PageNo - 1))
                .Take(request.PageSize).ToListAsync();

            List<ReviewDTO> ret = (from Review review in reviews
                                     select _mapper.Map<ReviewDTO>(review)).ToList();

            SearchResultDTO<ReviewDTO> result = new DTO.SearchResultDTO<ReviewDTO>() {
                PageNo = request.PageNo,
                PageSize = request.PageSize,
                TotalRecords = totalCount,
                Data = ret
            };

            return Ok(result);
        }

    }
}
