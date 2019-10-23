using AutoMapper;
using Flagfin.CoreAPI.DTO;
using Flagfin.CoreAPI.Models;

namespace Flagfin.CoreAPI.Configs
{
    public class AutoMapperProfile : Profile
    {
        public AutoMapperProfile()
        {
            // Employee Mappings
            CreateMap<Employee, EmployeeDTO>()
                .ForMember(dest => dest.EmployeeId, opt => opt.MapFrom(x => x.Id))
                .ForMember(dest => dest.UserId, opt => opt.MapFrom(x => x.User.Id))
                .ForMember(dest => dest.FirstName, opt => opt.MapFrom(x => x.User.FirstName))
                .ForMember(dest => dest.LastName, opt => opt.MapFrom(x => x.User.LastName))
                .ForMember(dest => dest.UserName, opt => opt.MapFrom(x => x.User.UserName))
                .ForMember(dest => dest.Email, opt => opt.MapFrom(x => x.User.Email));

            CreateMap<RegisterDTO, ApplicationUser>();

        }
    }
}
