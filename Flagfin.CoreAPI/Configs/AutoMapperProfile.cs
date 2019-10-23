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

            //Review mapping
            CreateMap<Review, ReviewDTO>()
                .ForMember(dest => dest.ReviewId, opt => opt.MapFrom(x => x.Id))
                .ForMember(dest => dest.ReviewerId, opt => opt.MapFrom(x => x.Reviewer.Id))
                .ForMember(dest => dest.ReviewerName, opt => opt.MapFrom(x => x.Reviewer.User.UserName))
                .ForMember(dest => dest.EmployeeId, opt => opt.MapFrom(x => x.Employee.Id))
                .ForMember(dest => dest.EmployeeName, opt => opt.MapFrom(x => x.Employee.User.UserName))
                .ForMember(dest => dest.Status, opt => opt.MapFrom(x => x.Status.ToString()))
                .ForMember(dest => dest.StatusId, opt => opt.MapFrom(x => (int)x.Status));

        }
    }
}
