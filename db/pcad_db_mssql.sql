USE [pcad_db]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__acc_eff___7C4F7684]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__ppm_actu__7B5B524B]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__yield_ac__7A672E12]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__daily_pl__797309D9]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__work_tim__787EE5A0]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__start_ba__778AC167]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__acc_eff__76969D2E]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__ppm_targ__75A278F5]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__yield_ta__74AE54BC]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__group__73BA3083]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__actual_s__72C60C4A]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__last_upd__71D1E811]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__last_tak__70DDC3D8]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__takt_sec__6FE99F9F]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__ended_DB__6EF57B66]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__datetime__6E01572D]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__is_pause__6D0D32F4]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__Remainin__6C190EBB]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__Actual_T__6B24EA82]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__Target__6A30C649]
GO
ALTER TABLE [dbo].[t_plan] DROP CONSTRAINT [DF__t_plan__ID_No__693CA210]
GO
ALTER TABLE [dbo].[m_st_accounts] DROP CONSTRAINT [DF__m_st_acco__date___66603565]
GO
ALTER TABLE [dbo].[m_st] DROP CONSTRAINT [DF__m_st__date_updat__6383C8BA]
GO
ALTER TABLE [dbo].[m_st] DROP CONSTRAINT [DF__m_st__inspection__628FA481]
GO
ALTER TABLE [dbo].[m_st] DROP CONSTRAINT [DF__m_st__final_assy__619B8048]
GO
ALTER TABLE [dbo].[m_st] DROP CONSTRAINT [DF__m_st__sub_assy__60A75C0F]
GO
ALTER TABLE [dbo].[m_process_design] DROP CONSTRAINT [DF__m_process__mp_co__3B75D760]
GO
ALTER TABLE [dbo].[m_process_design] DROP CONSTRAINT [DF__m_process__mp_co__3A81B327]
GO
ALTER TABLE [dbo].[m_ircs_line] DROP CONSTRAINT [DF__m_ircs_li__date___5AEE82B9]
GO
ALTER TABLE [dbo].[m_ircs_line] DROP CONSTRAINT [DF__m_ircs_li__ircs___59FA5E80]
GO
ALTER TABLE [dbo].[m_ircs_line] DROP CONSTRAINT [DF__m_ircs_li__line___59063A47]
GO
ALTER TABLE [dbo].[m_ircs_line] DROP CONSTRAINT [DF__m_ircs_li__car_m__5812160E]
GO
ALTER TABLE [dbo].[m_ircs_line] DROP CONSTRAINT [DF__m_ircs_li__car_m__571DF1D5]
GO
ALTER TABLE [dbo].[m_inspection_ip] DROP CONSTRAINT [DF__m_inspect__date___34C8D9D1]
GO
ALTER TABLE [dbo].[m_final_process] DROP CONSTRAINT [DF__m_final_p__date___33D4B598]
GO
/****** Object:  Table [dbo].[t_plan]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[t_plan]') AND type in (N'U'))
DROP TABLE [dbo].[t_plan]
GO
/****** Object:  Table [dbo].[m_st_accounts]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[m_st_accounts]') AND type in (N'U'))
DROP TABLE [dbo].[m_st_accounts]
GO
/****** Object:  Table [dbo].[m_st]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[m_st]') AND type in (N'U'))
DROP TABLE [dbo].[m_st]
GO
/****** Object:  Table [dbo].[m_process_design]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[m_process_design]') AND type in (N'U'))
DROP TABLE [dbo].[m_process_design]
GO
/****** Object:  Table [dbo].[m_pcs_accounts]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[m_pcs_accounts]') AND type in (N'U'))
DROP TABLE [dbo].[m_pcs_accounts]
GO
/****** Object:  Table [dbo].[m_ircs_line]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[m_ircs_line]') AND type in (N'U'))
DROP TABLE [dbo].[m_ircs_line]
GO
/****** Object:  Table [dbo].[m_inspection_ip]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[m_inspection_ip]') AND type in (N'U'))
DROP TABLE [dbo].[m_inspection_ip]
GO
/****** Object:  Table [dbo].[m_final_process]    Script Date: 2024/07/24 4:50:17 pm ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[m_final_process]') AND type in (N'U'))
DROP TABLE [dbo].[m_final_process]
GO
USE [master]
GO
/****** Object:  Database [pcad_db]    Script Date: 2024/07/24 4:50:17 pm ******/
DROP DATABASE [pcad_db]
GO
/****** Object:  Database [pcad_db]    Script Date: 2024/07/24 4:50:17 pm ******/
CREATE DATABASE [pcad_db]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'pcad_db', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\pcad_db.mdf' , SIZE = 73728KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'pcad_db_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\pcad_db_log.ldf' , SIZE = 73728KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [pcad_db].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [pcad_db] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [pcad_db] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [pcad_db] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [pcad_db] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [pcad_db] SET ARITHABORT OFF 
GO
ALTER DATABASE [pcad_db] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [pcad_db] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [pcad_db] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [pcad_db] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [pcad_db] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [pcad_db] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [pcad_db] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [pcad_db] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [pcad_db] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [pcad_db] SET  ENABLE_BROKER 
GO
ALTER DATABASE [pcad_db] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [pcad_db] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [pcad_db] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [pcad_db] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [pcad_db] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [pcad_db] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [pcad_db] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [pcad_db] SET RECOVERY FULL 
GO
ALTER DATABASE [pcad_db] SET  MULTI_USER 
GO
ALTER DATABASE [pcad_db] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [pcad_db] SET DB_CHAINING OFF 
GO
ALTER DATABASE [pcad_db] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [pcad_db] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [pcad_db] SET DELAYED_DURABILITY = DISABLED 
GO
USE [pcad_db]
GO
/****** Object:  Table [dbo].[m_final_process]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_final_process](
	[id] [bigint] IDENTITY(20,1) NOT NULL,
	[p_value] [nvarchar](2) NOT NULL,
	[final_process] [nvarchar](255) NOT NULL,
	[ipaddresscolumn] [nvarchar](255) NOT NULL,
	[finishdatetime] [nvarchar](255) NOT NULL,
	[judgement] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_m_final_process_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [m_final_process$final_process] UNIQUE NONCLUSTERED 
(
	[final_process] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_inspection_ip]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_inspection_ip](
	[id] [int] IDENTITY(73,1) NOT NULL,
	[ircs_line] [nvarchar](255) NOT NULL,
	[process] [nvarchar](255) NOT NULL,
	[ip_address] [nvarchar](255) NOT NULL,
	[ip_address2] [nvarchar](255) NOT NULL,
	[ipaddresscolumn] [nvarchar](255) NOT NULL,
	[finishdatetime] [nvarchar](255) NOT NULL,
	[judgement] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_m_inspection_ip_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_ircs_line]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_ircs_line](
	[id] [int] IDENTITY(251,1) NOT NULL,
	[car_maker] [nvarchar](255) NULL,
	[car_model] [nvarchar](255) NULL,
	[line_no] [nvarchar](255) NULL,
	[ircs_line] [nvarchar](255) NULL,
	[andon_line] [nvarchar](255) NOT NULL,
	[final_process] [nvarchar](255) NOT NULL,
	[ip] [nvarchar](50) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_m_ircs_line_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_pcs_accounts]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_pcs_accounts](
	[id] [int] IDENTITY(3,1) NOT NULL,
	[emp_id] [nvarchar](255) NOT NULL,
	[full_name] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_m_pcs_accounts_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_process_design]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_process_design](
	[id] [int] IDENTITY(41,1) NOT NULL,
	[ircs_line] [nvarchar](255) NOT NULL,
	[process_design] [nvarchar](255) NOT NULL,
	[mp_count_a] [int] NOT NULL,
	[mp_count_b] [int] NOT NULL,
 CONSTRAINT [PK_m_process_design_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_st]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_st](
	[id] [int] IDENTITY(2467,1) NOT NULL,
	[parts_name] [nvarchar](255) NOT NULL,
	[sub_assy] [float] NULL,
	[final_assy] [float] NULL,
	[inspection] [float] NULL,
	[st] [float] NOT NULL,
	[updated_by_no] [nvarchar](255) NOT NULL,
	[updated_by] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_m_st_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [m_st$parts_name] UNIQUE NONCLUSTERED 
(
	[parts_name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_st_accounts]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_st_accounts](
	[id] [int] IDENTITY(2,1) NOT NULL,
	[emp_no] [nvarchar](255) NOT NULL,
	[full_name] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_m_st_accounts_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_plan]    Script Date: 2024/07/24 4:50:17 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_plan](
	[ID] [int] IDENTITY(742,1) NOT NULL,
	[Carmodel] [nvarchar](255) NOT NULL,
	[Line] [nvarchar](255) NOT NULL,
	[ID_No] [nvarchar](255) NULL,
	[Target] [int] NOT NULL,
	[Actual_Target] [int] NOT NULL,
	[Remaining_Target] [nvarchar](255) NOT NULL,
	[Status] [nvarchar](255) NOT NULL,
	[is_paused] [nvarchar](255) NOT NULL,
	[IRCS_Line] [nvarchar](255) NOT NULL,
	[datetime_DB] [datetime2](0) NULL,
	[ended_DB] [datetime2](0) NULL,
	[takt_secs_DB] [int] NULL,
	[last_takt_DB] [int] NULL,
	[last_update_DB] [datetime2](0) NULL,
	[actual_start_DB] [datetime2](0) NULL,
	[IP_address] [nvarchar](50) NOT NULL,
	[group] [nvarchar](10) NULL,
	[yield_target] [int] NULL,
	[ppm_target] [int] NULL,
	[acc_eff] [int] NULL,
	[start_bal_delay] [int] NULL,
	[work_time_plan] [int] NULL,
	[daily_plan] [int] NULL,
	[yield_actual] [float] NULL,
	[ppm_actual] [int] NULL,
	[acc_eff_actual] [float] NULL,
 CONSTRAINT [PK_t_plan_ID] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[m_final_process] ADD  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_inspection_ip] ADD  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_ircs_line] ADD  DEFAULT (NULL) FOR [car_maker]
GO
ALTER TABLE [dbo].[m_ircs_line] ADD  DEFAULT (NULL) FOR [car_model]
GO
ALTER TABLE [dbo].[m_ircs_line] ADD  DEFAULT (NULL) FOR [line_no]
GO
ALTER TABLE [dbo].[m_ircs_line] ADD  DEFAULT (NULL) FOR [ircs_line]
GO
ALTER TABLE [dbo].[m_ircs_line] ADD  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_process_design] ADD  DEFAULT ((0)) FOR [mp_count_a]
GO
ALTER TABLE [dbo].[m_process_design] ADD  DEFAULT ((0)) FOR [mp_count_b]
GO
ALTER TABLE [dbo].[m_st] ADD  DEFAULT (NULL) FOR [sub_assy]
GO
ALTER TABLE [dbo].[m_st] ADD  DEFAULT (NULL) FOR [final_assy]
GO
ALTER TABLE [dbo].[m_st] ADD  DEFAULT (NULL) FOR [inspection]
GO
ALTER TABLE [dbo].[m_st] ADD  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_st_accounts] ADD  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [ID_No]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT ((0)) FOR [Target]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT ((0)) FOR [Actual_Target]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (N'0') FOR [Remaining_Target]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (N'NO') FOR [is_paused]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [datetime_DB]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [ended_DB]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT ((0)) FOR [takt_secs_DB]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT ((0)) FOR [last_takt_DB]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [last_update_DB]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [actual_start_DB]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [group]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [yield_target]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [ppm_target]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [acc_eff]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [start_bal_delay]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [work_time_plan]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [daily_plan]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [yield_actual]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [ppm_actual]
GO
ALTER TABLE [dbo].[t_plan] ADD  DEFAULT (NULL) FOR [acc_eff_actual]
GO
USE [master]
GO
ALTER DATABASE [pcad_db] SET  READ_WRITE 
GO
