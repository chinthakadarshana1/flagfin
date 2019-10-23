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
    public class EmployeeController : ControllerBase
    {

        private readonly UserManager<ApplicationUser> _userManager;
        private readonly RoleManager<IdentityRole> _roleManager;
        private readonly ApplicationDbContext _dbContext;
        private readonly IMapper _mapper;

        public EmployeeController(
            UserManager<ApplicationUser> userManager,
            RoleManager<IdentityRole> roleManager,
            ApplicationDbContext dbContext,
            IMapper mapper
        )
        {
            _userManager = userManager;
            _roleManager = roleManager;
            _dbContext = dbContext;
            _mapper = mapper;
        }

        [CustomAuthorization(UserTypes.Admin)]
        [HttpPost]
        public async Task<IActionResult> Get(EmployeeDTO request)
        {
            var employee = await _dbContext.Employees
                .Include(x => x.User)
                .FirstOrDefaultAsync(e => e.Id == request.EmployeeId);

            EmployeeDTO ret = _mapper.Map<EmployeeDTO>(employee);
            return Ok(ret);
        }

        [CustomAuthorization(UserTypes.Admin)]
        [HttpPost]
        public async Task<IActionResult> Add([FromBody] RegisterDTO request)
        {
            if (ModelState.IsValid)
            {
                //create identity user
                var user = _mapper.Map<ApplicationUser>(request);

                var result = await _userManager.CreateAsync(user, request.Password);

                if (result.Succeeded)
                {
                    string role = UserTypes.BasicUser.ToString();
                    if (await _roleManager.FindByNameAsync(role) == null)
                    {
                        await _roleManager.CreateAsync(new IdentityRole(role));
                    }
                    await _userManager.AddToRoleAsync(user, role);
                    await _userManager.AddClaimAsync(user, new System.Security.Claims.Claim("userName", user.UserName));
                    await _userManager.AddClaimAsync(user, new System.Security.Claims.Claim("firstName", user.FirstName));
                    await _userManager.AddClaimAsync(user, new System.Security.Claims.Claim("lastName", user.LastName));
                    await _userManager.AddClaimAsync(user, new System.Security.Claims.Claim("email", user.Email));
                    await _userManager.AddClaimAsync(user, new System.Security.Claims.Claim("role", role));

                    //create employee
                    Employee employee = new Employee();
                    employee.JobTitle = request.JobTitle;
                    employee.User = new ApplicationUser() { Id = user.Id };

                    _dbContext.Employees.Add(employee);
                    await _dbContext.SaveChangesAsync();

                    EmployeeDTO ret = _mapper.Map<EmployeeDTO>(employee);
                    return Ok(ret);
                }
                else
                {
                    return BadRequest(result.Errors);
                }
            }
            else
                return BadRequest(ModelState);
        }

        [CustomAuthorization(UserTypes.Admin)]
        [HttpPost]
        public async Task<IActionResult> Update([FromBody] RegisterDTO request)
        {
            if (ModelState.IsValid)
            {
                var employee = await _dbContext.Employees
                   .Include(x => x.User)
                   .FirstOrDefaultAsync(e => e.Id == request.EmployeeId);

                if (employee != null)
                {
                    //updating identity user
                    employee.User.UserName = request.UserName;
                    employee.User.FirstName = request.FirstName;
                    employee.User.LastName = request.LastName;
                    employee.User.Email = request.Email;
                    employee.User.PasswordHash = _userManager.PasswordHasher.HashPassword(employee.User, request.Password);

                    var identityResult = await _userManager.UpdateAsync(employee.User);

                    if (identityResult.Succeeded)
                    {
                        //update employee
                        employee.JobTitle = request.JobTitle;

                        await _dbContext.SaveChangesAsync();

                        EmployeeDTO ret = _mapper.Map<EmployeeDTO>(employee);
                        return Ok(ret);
                    }
                    else
                    {
                        return BadRequest(identityResult.Errors);
                    }
                }
                return BadRequest("Invalid Employee");
            }
            else
                return BadRequest(ModelState);
        }

        [CustomAuthorization(UserTypes.Admin)]
        [HttpPost]
        public async Task<IActionResult> Delete([FromBody] EmployeeDTO request)
        {
            var employee = await _dbContext.Employees
                .Include(x => x.User)
                .FirstOrDefaultAsync(e => e.Id == request.EmployeeId);

            //delete identity user
            var identityResult = await _userManager.DeleteAsync(employee.User);
            if (identityResult.Succeeded)
            {
                _dbContext.Employees.Remove(employee);
                await _dbContext.SaveChangesAsync();
                return Ok(request);
            }
            else
            {
                return BadRequest(identityResult.Errors);
            }

        }

        [CustomAuthorization(UserTypes.BasicUser)]
        [HttpPost]
        public async Task<IActionResult> GetCurrentUser()
        {
            string userId = HttpContext.User.Claims.FirstOrDefault(c => c.Type == ClaimTypes.NameIdentifier)?.Value;

            var user = await _userManager.FindByIdAsync(userId);

            if (user == null)
                return BadRequest("User Cannotbe found!");
            else
            {
                var employee = await _dbContext.Employees
                   .Include(x => x.User)
                   .FirstOrDefaultAsync(e => e.User.Id == user.Id);
                EmployeeDTO ret = _mapper.Map<EmployeeDTO>(employee);
                return Ok(ret);
            }
        }


        [CustomAuthorization(UserTypes.Admin)]
        [HttpPost]
        public async Task<IActionResult> SearchUser(SearchQueryDTO<EmployeeDTO> request)
        {
            //creating dynamic search query
            IQueryable<Employee> query = _dbContext.Employees.Include(x => x.User);

            if (!string.IsNullOrEmpty(request.FreeText))
            {
                query = query
                    .Where(en => EF.Functions.Like(en.User.FirstName, $"%{request.FreeText}%") ||
                                    EF.Functions.Like(en.User.LastName, $"%{request.FreeText}%") ||
                                    EF.Functions.Like(en.User.UserName, $"%{request.FreeText}%") ||
                                    en.Id== request.SearchModel.EmployeeId);
            }
            else
            {
                query = query
                    .Where(en => (string.IsNullOrEmpty(request.SearchModel.FirstName) || EF.Functions.Like(en.User.FirstName, $"%{request.SearchModel.FirstName}%")) &&
                                 (string.IsNullOrEmpty(request.SearchModel.LastName) || EF.Functions.Like(en.User.LastName, $"%{request.SearchModel.LastName}%")) &&
                                 (string.IsNullOrEmpty(request.SearchModel.UserName) || EF.Functions.Like(en.User.UserName, $"%{request.SearchModel.UserName}%")) &&
                                 (request.SearchModel.EmployeeId == 0 || en.Id == request.SearchModel.EmployeeId));
            }

            // Execute the query
            var totalCount = await query.CountAsync();
            var employees = await query.Skip(request.PageSize * (request.PageNo - 1))
                            .Take(request.PageSize).ToListAsync();

            List<EmployeeDTO> ret = (from Employee emp in employees
                                     select _mapper.Map<EmployeeDTO>(emp)).ToList();

            SearchResultDTO<EmployeeDTO> result = new DTO.SearchResultDTO<EmployeeDTO>() {
                PageNo = request.PageNo,
                PageSize = request.PageSize,
                TotalRecords = totalCount,
                Data = ret
            };

            return Ok(result);
        }
    }
}
