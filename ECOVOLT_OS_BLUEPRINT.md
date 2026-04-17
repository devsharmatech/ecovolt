# EcoVolt Solar CRM - Operating System Blueprint (Official Roadmap)

This document is the absolute source of truth for the development, execution, and scaling of the EcoVolt Solar Panel Portal.

## 1. Core Principles
- **Solar-First CRM**: Tailored specifically for solar industry workflows (no generic CRM fields).
- **GST-Inclusive Pricing**: 8.9% overall inclusive tax rate.
- **SLA-Driven**: Strict 12h/18h action windows.
- **Payment-Driven**: Clear 70/30 payment split milestones.
- **Approval-Controlled**: Multi-tier discount and margin protection logic.
- **Pan-India Scalability**: Designed for multi-region dealer networks.

---

## 2. Pricing & GST Logic (GST-Inclusive – 8.9%)

### 2.1 Standard Pricing per kW (Inclusive)
- **On-grid**: ₹65,000 / kW
- **Hybrid**: ₹90,000 / kW
- **Off-grid**: ₹55,000 / kW

### 2.2 GST Implementation
- **Overall Rate**: 8.9%
- **All prices are GST-inclusive**.
- **System Automation**: The system must automatically calculate:
    - **Taxable Value** (Base price)
    - **GST Amount**
    - **Total Invoice Value** (Final price)
- **Margin Floor**: Minimum **15% Margin**. Dealing below this is a **Hard Stop** (System block).

---

## 3. Payment & Discount Structures

### 3.1 Payment Split
- **70% Initial**: Booking Amount.
- **30% Final**: Commissioning Amount.

### 3.2 Discount & Approval Tiers
- **Employee**: 0% (No discount authority).
- **Manager**: Up to 5% discount power.
- **COO**: Up to 10% discount power.
- **MD**: Authority for discounts above 10%.
- **Hard Rule**: Margin must stay above **15% Floor**.

---

## 4. Document & ID System

### 4.1 Mandatory Document Requirements (KYC)
1.  **PAN Card**
2.  **Aadhaar Card**
3.  **Electricity Bill**
4.  **Bank Statement**
5.  **Email ID**
6.  **Mobile Number**
7.  **Geo-tagged Photographs** (MANDATORY for survey and installation).

### 4.2 Unique Identifiers
- **Lead ID**: (Unique Tracking)
- **Project ID**: (Unique Project Tracking)
- **Dealer ID**: (Must be unique - tracked for payouts)
- **Customer ID**: (Must be unique - used for OTP login)

---

## 5. Master Workflow Flowchart

### 5.1 The Project Lifecycle
`Lead` -> `Assignment` -> `Qualification` -> `Survey` -> `Quotation` -> `Approval` -> `Booking (70%)` -> `Project Creation` -> `Unified Processing Flow` -> `Commissioning (30%)` -> `Subsidy Redemption` -> `Closure`.

### 5.2 Unified Project Flow (Deep Dive)
- **KYC Complete**
- **Geo-tag Photo Upload**
- **PM Suryaghar Registration**
- **Payment Mode Selection** (Cash OR Bank).

#### CASE A: IF CASH
- Net Metering
- Inspection
- Part Payment
- Commissioning
- Subsidy Redemption

#### CASE B: IF BANK
- Bank Login
- Bank Disbursement
- (If Yes) -> Net Metering -> Inspection -> Part Payment -> Commissioning -> Subsidy Redemption.

---

## 6. Detailed Role-Based Workflows

### 6.1 Admin Workflow
- Lead Assignment.
- SLA Monitoring (12h / 18h).
- Approval Control.
- Flow Control (Cash vs Bank oversight).
- Subsidy tracking management.
- Dealer network monitoring.

### 6.2 Employee Workflow
- `Lead Assigned` -> `Qualification` -> `Survey` -> `Quotation` -> `Booking (70%)`.
- Document Collection & KYC compliance.
- Bank Login (if bank case).
- Installation status updates.
- Net Metering facilitation.
- Part Payment collection management.
- Commissioning (30%) & Subsidy Redemption.

### 6.3 Accounts Workflow
- Validate 70% booking payment.
- Validate 30% commissioning payment.
- **GST Invoice Generation**.
- Outstanding Payment tracking.
- Bank disbursement monitoring.
- **Dealer Payout** management.
- Exporting financial reports.

### 6.4 Dealer Workflow
- Lead Creation (Dealer ID is mandatory).
- Project Tracking.
- Discount Request (Requesting tier approval).
- Commission & Payout tracking.

### 6.5 Customer Workflow
- **OTP Login** (Customer ID mandatory).
- View & Approve Proposals.
- Online/Offline Payment (70% and 30%).
- Project Status Tracking.
- Subsidy tracking.
- Use **RMS** (Remote Monitoring System).

---

## 7. Operational Rules (SLA & Subsidy)

### 7.1 SLA Monitoring Rules
- **12 Hours Delay**: Notification to **Manager**.
- **18 Hours Delay**: Automatic **Escalation** to Admin/COO.

### 7.2 Subsidy Flow (PM Suryaghar)
- **Target Timeline**: 25 Days.
- **Process**: Registration -> Net Metering -> Inspection -> Commissioning -> Subsidy Redemption.

---

## 8. AMC Plans (Annual Maintenance)
- **₹1,500**: Half-yearly cleaning.
- **₹2,000**: Quarterly cleaning.
- **₹3,000**: Bi-monthly cleaning.
- **₹1,000 Add-on**: Optional yearly insurance for the system.

---

## 9. Telecalling & Analytics
- Tracking of **Qualified Leads**.
- Appointment management.
- Conversion tracking metrics.

---

## 10. System Strengths (Final Recap)
- **Unified Process**: Everyone on one platform.
- **Bank + Cash Integration**: Seamless handling of financing modes.
- **Geo-tag Validation**: Proof-of-work at survey and installation.
- **Approval Control**: Margin protection and hierarchy.
- **GST Compliant**: Automated tax handling.
- **Highly Scalable**: Pan-India support.
