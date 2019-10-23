using Flagfin.CoreAPI.Models.Enum;
using IdentityServer4.Extensions;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Filters;

namespace Flagfin.CoreAPI.Filters
{
    public class CustomAuthorization : AuthorizeAttribute, IAuthorizationFilter
    {
        private readonly string _roleName = null;

        public CustomAuthorization(UserTypes userType)
        {
            _roleName = userType.ToString();
        }


        public void OnAuthorization(AuthorizationFilterContext context)
        {
            if (context.HttpContext.User.IsAuthenticated())
            {
                if (!string.IsNullOrEmpty(_roleName))
                {
                    var hasClaim = context.HttpContext.User.IsInRole(_roleName);
                    if (!hasClaim)
                    {
                        context.Result = new ForbidResult();
                    }
                }
            }
            else
            {
                context.Result = new UnauthorizedResult();
            }
        }
    }
}
